<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixNewsletterUsersCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('kinder2:fix-newsletter-users')
            ->setDescription('Fix newsletters users and groups');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $progenitores = $em->getRepository('AppBundle:Progenitor')->findAll();
        $starttime = time();
        $output->writeln(sprintf('Fix newsletters users and groups'));
        foreach ($progenitores as $progenitor) {
            $this->getContainer()->get('kinder.newslettersync')->regenerateProgenitorNewsletter($progenitor);
        }
        $output->writeln(sprintf('Finish Fix newsletters users and groups: %s seconds duration', time() - $starttime ));
    }
}
