<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CompareFilesCommand
 * @package AppBundle\Command
 */
class TestCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('test:mail')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $campaignMonitor = $this->getContainer()->get('campaign.monitor.service');
//        for ($i = 1; $i <= 1000; $i++) {
//
//        }
        $campaignMonitor->subscribe("nestorasst@gmail.com", "Nestoras Stefanou");
        
        //$results = $campaignMonitor->getActiveSubscribers();
       // dump($results);
        //$campaignMonitor->delete("nestorasst@gmail.com");

        $output->writeln('Command result.');
    }

}

