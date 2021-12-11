<?php

/**
 * Created by PhpStorm.
 * User: KaporalK
 * Date: 01/06/2019
 * Time: 21:17
 */

namespace App\Command;

use App\Entity\Sql\ItemCategory;
use App\Entity\Sql\ItemProperties;
use App\Entity\Sql\Items;
use App\Entity\Sql\nEntity\Properties;
use App\Entity\Sql\nEntity\Requirement;
use App\Entity\Sql\nEntity\Socket;
use App\Entity\Sql\Stashes;
use App\Service\ApiHelper;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PopulatePoeBdd extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'poe:populate-bdd';

    private ApiHelper $apiHelp;

    private EntityManagerInterface $entityManager;
    private EntityRepository $categoryRepo;
    private EntityRepository $stashRepo;
    private EntityRepository $itemRepo;

    public function __construct(EntityManagerInterface $entityManager, ApiHelper $apiHelp)
    {
        $this->apiHelp = $apiHelp;
        $this->entityManager = $entityManager;
        $this->categoryRepo = $entityManager->getRepository(ItemCategory::class);
        $this->stashRepo = $entityManager->getRepository(Stashes::class);
        $this->itemRepo = $entityManager->getRepository(Items::class);
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this->setDescription('Populate the Bdd')
            ->setHelp('TODO');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {

            // ...
            $output->writeln('Cleaning database');

            exec('php bin/console dbal:run-sql "$(< ./resources/clean.sql)"');

            $output->writeln('Sending request');
            //todo faire ça mieux
            $this->apiHelp->resetOption();

            $this->apiHelp->setApiUrl(getenv('POE_ITEM_DUMP'));
            $this->apiHelp->addHeader(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0']);

            $content = $this->apiHelp->sendHttpGetContentRequest();
            $stashesJson = $content['stashes'];
            $output->writeln(sprintf('Next content id : %s', $content['next_change_id']));
            $output->writeln(sprintf('%s stashes to popualte', count($stashesJson)));
            $i = 1;

            // Set Stashes
            foreach ($stashesJson as $stasheJson) {
                $output->writeln(sprintf("Populatinf for id %s", $stasheJson['id']));

                $stashes = $this->hydrateStashes($stasheJson);
                //Set Items
                foreach ($stasheJson['items'] as $itemJson) {

                    $itempoe = $this->hdyrateItem($itemJson);
                    $stashes->addItem($itempoe);

                    //Set Categories
                    $categoryActual = $this->hydrateCategory($itemJson['extended']['category'], 'prime');
                    $itempoe->addCategory($categoryActual);

                    if (isset($itemJson['extended']['subcategories'])) {
                        foreach ($itemJson['extended']['subcategories'] as $categoryName) {
                            $categoryActual = $this->hydrateCategory($categoryName, 'sub');
                            $itempoe->addCategory($categoryActual);
                        }
                    }

                    ////////tttttttttttttttooooooooooooooooodddddddddddddooooooooooooooooooooo
                    //les mods != les properties
                    if (isset($itemJson['properties'])) {
                        foreach ($itemJson['properties'] as $property) {
                            $itemProperty = new Properties();
                            $itemProperty->setName($property['name']);
                            $itemProperty->setValues($property['values']);
                            $itemProperty->setDisplayMode($property['displayMode']);
                            if (isset($property['type'])) {
                                $itemProperty->setType($property['type']);
                            }
                            $itempoe->addProperties($itemProperty);
                        }
                    }
                }
                //                ->setItems($stasheJson['items']);

                $this->entityManager->persist($stashes);

                if ($i % 50 === 0) {
                    $output->writeln("saving 50");
                    $this->entityManager->flush();
                }

                $i++;
            }
            $output->writeln("saving last");

            $this->entityManager->flush();

            return 0;
        } catch (Exception $e) {
            //debug de folie
            echo "ERROROROROROROROROORO";
            // var_dump($itemJson);

            throw $e;
        }
    }


    public function hydrateStashes(array $stasheJson): Stashes
    {
        $stasheExist = $this->stashRepo->findOneBy([
            'poeId' => $stasheJson['id']
        ]);
        if ($stasheExist instanceof Stashes) {
            $stashe = $stasheExist;
        } else {
            $stashe = new Stashes();
        }
        $stashe->setPoeId($stasheJson['id'])
            ->setIsPublic($stasheJson['public'])
            ->setAccountName($stasheJson['accountName'])
            ->setLastCharacterName($stasheJson['lastCharacterName'])
            ->setStash($stasheJson['stash'])
            ->setStashType($stasheJson['stashType'])
            ->setLeague($stasheJson['league']);

        return $stashe;
    }

    public function hdyrateItem(array $itemJson): Items
    {
        $itemExist = $this->itemRepo->findOneBy([
            'poeId' => $itemJson['id']
        ]);
        if ($itemExist instanceof Items) {
            $itempoe = $itemExist;
        } else {
            $itempoe = new Items();
        }
        $itempoe->setPoeId($itemJson['id']);
        $itempoe->setVerified($itemJson['verified']);
        $itempoe->setW($itemJson['w']);
        $itempoe->setH($itemJson['h']);
        $itempoe->setIlvl($itemJson['ilvl']);
        $itempoe->setIcon($itemJson['icon']);
        $itempoe->setLeague($itemJson['league']);
        $itempoe->setName($itemJson['name']);
        $itempoe->setTypeLine($itemJson['typeLine']);
        $itempoe->setIdentified($itemJson['identified']);
        if (isset($itemJson['note'])) {
            $itempoe->setNote($itemJson['note']);
        }
        if (isset($itemJson['explicitMods'])) {
            $itempoe->setExplicitMods($itemJson['explicitMods']);
        }
        if (isset($itemJson['flavourText'])) {
            $itempoe->setFlavourText($itemJson['flavourText']);
        }
        if (isset($itemJson['secDescrText'])) {
            $itempoe->setSecDescrText($itemJson['secDescrText']);
        }
        if (isset($itemJson['descrText'])) {
            $itempoe->setDescrText($itemJson['descrText']);
        }
        $itempoe->setFrameType($itemJson['frameType']);
        $itempoe->setX($itemJson['x']);
        $itempoe->setY($itemJson['y']);
        $itempoe->setInventoryId($itemJson['inventoryId']);


        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer, new ArrayDenormalizer()], [new JsonEncoder()]);

        if (isset($itemJson['sockets'])) {
            $sockets = $serializer->deserialize(json_encode($itemJson['sockets']), Socket::class . '[]', 'json');
            $itempoe->setSockets($sockets);
        }
        if (isset($itemJson['requirements'])) {
            $requirements = $serializer->deserialize(json_encode($itemJson['requirements']), Requirement::class . '[]', 'json');
            $itempoe->setRequirements($requirements);
        }

        return $itempoe;
    }

    public function hydrateCategory(string $category, string $type = 'prime'): ItemCategory
    {
        $categoryExist = $this->categoryRepo->findOneBy([
            'category' => $category,
            'type' => $type
        ]);
        /**
         * @var ItemCategory $categoryExist
         */
        $categoryActual = null;
        if ($categoryExist instanceof ItemCategory) {
            $categoryActual = $categoryExist;
        }
        if ($categoryActual === null) {
            $categoryActual = new ItemCategory();
            $categoryActual->setType($type);
            $categoryActual->setCategory($category);
            //Insta persist + flush pour être sur d'avoir actualisé la liste pour la prochaine boucle
            $this->entityManager->persist($categoryActual);
            $this->entityManager->flush();
        }

        return $categoryActual;
    }
}
