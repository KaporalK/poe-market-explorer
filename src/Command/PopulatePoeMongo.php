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
use App\Service\PropertiesGeneratorService;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Persistence\ObjectRepository;
use Exception;
use MongoDB\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
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

                    
                    if(isset($item['properties'])){
                        foreach($item['properties'] as &$propertie){
                            if(isset($propertie['values'][0])){
                                $propertie['values'] = $propertie['values'][0];
                            }
                            
                            $exist = $this->propertiesRepo->findOne(['name' => $propertie['name']]);
                            $existType = null;
                            if(isset($propertie['type'])){
                                $propertie = PropertiesGeneratorService::handlePropertiesByType($propertie, $propertie['type']);
                                $existType = $this->propertiesRepo->findOne(['type' => $propertie['type']]);
                            }

                            if( $exist === null || $existType === null){
                                $this->propertiesRepo->insertOne($propertie);
                            }
                        }
                    }


                    if (isset($item['explicitMods'])) {
                        $explicitMods = $item['explicitMods'];
                        foreach ($explicitMods as $explicitMod) {
                            $slug =  preg_replace('/\s+/u', '_', preg_replace('/[\d]+\.[\d]+|[\d]+/u', 'X', $explicitMod));
                            $modExist = $this->modsRepo->findOne(['slug' => $slug]);
                            if ($modExist === null) {
                                preg_match_all('/[\d]+\.[\d]+|[\d]+/u', $explicitMod, $matche);

                                $modDatas = [
                                    'slug' => $slug,
                                    'text' => preg_replace('/[\d]+\.[\d]+|[\d]+/u', 'X', $explicitMod),
                                    'replace' => preg_replace('/[\d]+\.[\d]+|[\d]+/u', '%s', $explicitMod),
                                    'nbValue' => count($matche[0]),
                                ];
                                $modExist = $this->modsRepo->insertOne($modDatas);
                            }
                        }
                    }

                    if(isset($item['sockets'])){
                        $currentGroup = null;
                        $socketExtend = ['socketCount' => 0, 'G' => 0, 'R' => 0, 'B' => 0, 'W' => 0, 'link' => [], 'linkStr' => ''];
                        foreach($item['sockets'] as $socket){
                            $socketExtend['socketCount'] += 1;
                            $socketExtend[$socket['sColour']] += 1;
                            if($socket['sColour'] === 'W'){
                                $socketExtend['G'] += 1;
                                $socketExtend['B'] += 1;
                                $socketExtend['R'] += 1;
                            }
                            if($currentGroup !== $socket['group']){
                                $currentGroup = $socket['group'];
                                $socketExtend['linkStr'] .= ' ';
                            }
                            if(!isset($socketExtend['link'][$currentGroup])){
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
            $output->writeln("saving last");

            $this->documentManager->flush();

            return 0;
        } catch (Exception $e) {
            //debug de folie
            echo "ERROROROROROROROROORO";
            // var_dump($itemJson);

            throw $e;
        }
    }
}
