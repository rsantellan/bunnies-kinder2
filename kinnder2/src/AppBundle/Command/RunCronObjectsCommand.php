<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCronObjectsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('kinder2:run-cron-objects')
            ->setDescription('Runs the cron objects');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $starttime = time();
        $output->writeln(sprintf('Starting cron objects'));
        $this->getContainer()->get('kinder.crons')->processOneCron();
        $output->writeln(sprintf('Finish cron objects: %s seconds duration', time() - $starttime ));
    }
}
