<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FixParentsAccountsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('kinder2:fix-parent-account')
            ->setDescription('Fix parent accounts');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $progenitores = $em->getRepository('AppBundle:Progenitor')->findAll();

        foreach ($progenitores as $progenitor) {
            if (!$progenitor->getEstudiantes()->isEmpty()) {
                $estudiante = $progenitor->getEstudiantes()->first();
                $progenitor->setCuenta($estudiante->getCuenta());
                $em->persist($progenitor);
                $em->flush();
            }
        }
    }
}
