<?php

/**
 * Created by PhpStorm.
 * User: KaporalK
 * Date: 01/06/2019
 * Time: 21:17
 */

namespace App\Command;

use App\Entity\Mongo\Items;
use App\Entity\Mongo\Mods;
use App\Entity\Mongo\Properties;
use App\Entity\Mongo\Stashes;
use App\Service\ApiHelper;
use App\Service\ModsGeneratorService;
use App\Service\PropertiesGeneratorService;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Persistence\ObjectRepository;
use Exception;
use MongoDB\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PopulatePoeMongo extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'poe:populate-bdd:mongo';

    private ApiHelper $apiHelp;

    private DocumentManager $documentManager;
    private Collection  $stashRepo;
    private Collection $itemRepo;
    private Collection $modsRepo;
    private Collection $propertiesRepo;

    public function __construct(DocumentManager $documentManager, ApiHelper $apiHelp)
    {
        $this->apiHelp = $apiHelp;
        $this->documentManager = $documentManager;
        $this->stashRepo = $this->documentManager->getDocumentCollection(Stashes::class);
        $this->itemRepo = $this->documentManager->getDocumentCollection(Items::class);
        $this->modsRepo = $this->documentManager->getDocumentCollection(Mods::class);
        $this->propertiesRepo = $this->documentManager->getDocumentCollection(Properties::class);
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this->setDescription('Populate the Bdd')
            ->addOption('stashId', 's', InputOption::VALUE_OPTIONAL, 'stashId to startWith')
            ->addOption('page', 'p', InputOption::VALUE_OPTIONAL, 'Number of page to fetch')
            ->setHelp('TODO');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {

            // ...
            $output->writeln('Cleaning database');
            $output->writeln('Todo ?');


            $output->writeln('Sending request');
            //todo faire ça mieux
            $page = 0;

            $id = $input->getOption('stashId');
            $maxPage = $input->getOption('page') ?? 1;
            $url = getenv('POE_ITEM_DUMP') ?? 'missing_stash_url';
            if ($id !== null) {
                $url .= '?' . http_build_query(['id' => $id]);
            }

            $i = 1;

            do {

                $output->writeln('----------------');
                $this->apiHelp->resetOption();
                $this->apiHelp->setApiUrl($url);
                $this->apiHelp->addHeader(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0']);
                $output->writeln($url);
                $content = $this->apiHelp->sendHttpGetContentRequest();
                $stashesJson = $content['stashes'];
                $output->writeln(sprintf('Next content id : %s', $content['next_change_id']));
                $output->writeln(sprintf('%s stashes to popualte', count($stashesJson)));

                // Set Stashes
                foreach ($stashesJson as $stasheJson) {
                    $output->writeln(sprintf("Populating for id %s", $stasheJson['id']));

                    $stashe = $stasheJson;
                    $items = $stasheJson['items'];
                    unset($stashe['items']);
                    $stashe['_id'] = $stashe['id'];

                    $updated = $this->stashRepo->findOneAndReplace(['id' => $stashe['id']], $stashe);
                    if ($updated === null) {
                        $this->stashRepo->insertOne($stashe);
                    }

                    foreach ($items as $item) {
                        $item['stashe'] = $stashe['id'];
                        $item['_id'] = $item['id'];


                        if (isset($item['properties'])) {
                            foreach ($item['properties'] as &$propertie) {
                                $name = $propertie['name'];
                                if (empty($propertie['name'])) { // ???
                                    var_dump('-----EMPTY NAME-------');
                                    var_dump($propertie['values']);
                                    $name = $propertie['values'][0];
                                    var_dump($name);
                                }
                                ////Debug ----

                                if (isset($propertie['type'])) {
                                    $propertie = PropertiesGeneratorService::handlePropertiesByType($propertie, $propertie['type']);
                                    $otherPropertie = $propertie;
                                } else {
                                    $otherPropertie = PropertiesGeneratorService::handleOtherProperties($propertie);
                                    if (isset($otherPropertie['name'])) {
                                        $propertie = $otherPropertie;
                                    } else {
                                        $tags = $otherPropertie;
                                    }
                                }

                                if (is_array($otherPropertie) && !empty($otherPropertie) && !isset($otherPropertie['name'])) {
                                    foreach ($otherPropertie as $prop) {
                                        $find = $prop;
                                        unset($find['values']);
                                        unset($find['extendValues']);
                                        $exist = $this->propertiesRepo->findOne($find);
                                        if ($exist === null) {
                                            $this->propertiesRepo->insertOne($prop);
                                        }
                                    }
                                } elseif (is_array($otherPropertie)) {
                                    $find = $otherPropertie;
                                    unset($find['values']);
                                    unset($find['extendValues']);
                                    $exist = $this->propertiesRepo->findOne($find);
                                    if ($exist === null) {
                                        $this->propertiesRepo->insertOne($otherPropertie);
                                    }
                                }
                                if ($propertie === null) {
                                    throw new Exception('null properties');
                                }
                            }
                        }

                        if (isset($item['extended']['category']) && in_array($item['extended']['category'], ['jewels', 'armour', 'flasks', 'weapons', 'accessories'])) {
                            $modExt = [];
                            if (isset($item['explicitMods'])) {
                                $explicitMods = $item['explicitMods'];
                                foreach ($explicitMods as $explicitMod) {
                                    //Mod Document
                                    $slug =  ModsGeneratorService::makeSlugForMod($explicitMod);
                                    $modExist = $this->modsRepo->findOne(['slug' => $slug]);
                                    if ($modExist === null) {

                                        $modDatas = ModsGeneratorService::handleMods($explicitMod, $slug, 'explicit');
                                        $modExist = $this->modsRepo->insertOne($modDatas);
                                    }
                                    //Mod Ext

                                    $modExt[] = ModsGeneratorService::handleModsExt($explicitMod, 'explicit');
                                }
                            }
                            if (isset($item['implicitMods'])) {
                                $implicitMods = $item['implicitMods'];
                                foreach ($implicitMods as $implicitMod) {
                                    //Mod Document
                                    $slug =  ModsGeneratorService::makeSlugForMod($implicitMod);
                                    $modExist = $this->modsRepo->findOne(['slug' => $slug]);
                                    if ($modExist === null) {

                                        $modDatas = ModsGeneratorService::handleMods($implicitMod, $slug, 'implicit');
                                        $modExist = $this->modsRepo->insertOne($modDatas);
                                    }
                                    //Mod Ext
                                    $modExt[] = ModsGeneratorService::handleModsExt($implicitMod, 'implicit');
                                }
                            }
                            $item['modExts'] = $modExt;
                        }
                        if (isset($item['extended']['category'])) {
                            $exist = $this->propertiesRepo->findOne(['tag' => 'Category', 'name' => $item['extended']['category']]);
                            if ($exist === null) {
                                $this->propertiesRepo->insertOne(['tag' => 'Category', 'name' => $item['extended']['category']]);
                            }
                            if (isset($item['extended']['subcategories']) && !empty($item['extended']['subcategories'])) {
                                foreach ($item['extended']['subcategories'] as $subcategories) {
                                    $exist = $this->propertiesRepo->findOne(['tag' => 'SubCategory', 'name' => $subcategories]);
                                    if ($exist === null) {
                                        var_dump($subcategories);
                                        $this->propertiesRepo->insertOne(['tag' => 'SubCategory', 'name' => $subcategories]);
                                    }
                                }
                            }
                        }

                        if (isset($item['sockets'])) {
                            $currentGroup = null;
                            $socketExtend = ['socketCount' => 0, 'G' => 0, 'R' => 0, 'B' => 0, 'W' => 0, 'DV' => 0, 'A' => 0, 'link' => [], 'linkStr' => ''];
                            foreach ($item['sockets'] as $socket) {
                                $socketExtend['socketCount'] += 1;
                                $socketExtend[$socket['sColour']] += 1;
                                if ($socket['sColour'] === 'W') {
                                    $socketExtend['G'] += 1;
                                    $socketExtend['B'] += 1;
                                    $socketExtend['R'] += 1;
                                }
                                if ($currentGroup !== $socket['group']) {
                                    $currentGroup = $socket['group'];
                                    $socketExtend['linkStr'] .= ' ';
                                }
                                if (!isset($socketExtend['link'][$currentGroup])) {
                                    $socketExtend['link'] = array_merge($socketExtend['link'], [$currentGroup => 0]);
                                }
                                $socketExtend['link'][$currentGroup] += 1;
                                $socketExtend['linkStr'] .= $socket['sColour'];
                            }
                            $socketExtend['linkStr'] = trim($socketExtend['linkStr']);

                            $item['socketsExt'] = $socketExtend;
                        }


                        $updated = $this->itemRepo->findOneAndReplace(['id' => $item['id']], $item);
                        if ($updated === null) {
                            $this->itemRepo->insertOne($item);
                        }
                    }

                    if ($i % 50 === 0) {
                        $output->writeln("saving 50");
                        $this->documentManager->flush();
                    }

                    $i++;
                }

                $url = (getenv('POE_ITEM_DUMP') ?? 'missing_stash_url') . '?' . http_build_query(['id' => $content['next_change_id']]);
                $page++;
            } while ($page < $maxPage);
            $output->writeln("saving last");

            $this->documentManager->flush();
            $output->writeln("next Stash id {$content['next_change_id']}");
            return 0;
        } catch (Exception $e) {
            //debug de folie
            echo "ERROROROROROROROROORO";
            var_dump($item);
            var_dump($content['next_change_id']);

            throw $e;
        }
    }
}
