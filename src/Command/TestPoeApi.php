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
use App\Entity\Sql\Stashes;
use App\Service\ApiHelper;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestPoeApi extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'poe:test-api';

    private $apiHelp;

    private $entityManager;
    private $categoryRepo;

    public function __construct(EntityManagerInterface $entityManager, ApiHelper $apiHelp)
    {
        $this->apiHelp = $apiHelp;
        $this->entityManager = $entityManager;
        $this->categoryRepo = $entityManager->getRepository(ItemCategory::class);
        parent::__construct(self::$defaultName);
    }

    protected function configure()
    {
        $this->setDescription('test the api')
            ->setHelp('TODO');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {

            $output->writeln('Sending request');
            //todo faire ça mieux
            $this->apiHelp->resetOption();

            $this->apiHelp->setApiUrl(getenv('POE_ITEM_DUMP'));
            $this->apiHelp->addHeader(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0']);

            $content = $this->apiHelp->sendHttpGetContentRequest();
            $i = 1;
            
            do {
                
                $stashesJson = $content['stashes'];
                $contentId = $content['next_change_id'];
                $output->writeln(sprintf('Next content id : %s', $content['next_change_id']));
                $output->writeln(sprintf('%s stashes to popualte', count($stashesJson)));


                $this->apiHelp->setApiUrl(getenv('POE_ITEM_DUMP') .'?'. http_build_query(['id' => $contentId]));
                $this->apiHelp->addHeader(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:94.0) Gecko/20100101 Firefox/94.0']);
    
                $content = $this->apiHelp->sendHttpGetContentRequest();

                sleep(30);

            }while(isset($content['next_change_id']));

            return 0;
        } catch (Exception $e) {
            //debug de folie
            echo "ERROROROROROROROROORO";
            // var_dump($itemJson);

            throw $e;
        }
    }
}
