<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use FOS\UserBundle\Mailer\Mailer;

use AppBundle\Entity\Progenitor;

class ProgenitoresService
{
    protected $em;

    protected $logger;

    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->logger->addDebug('Starting progenitores service');
    }

    public function createProgenitor(Progenitor $progenitor, Mailer $mailer){
        $dbProgenitor = $this->em->getRepository('AppBundle:Progenitor')->checkEmailExists($progenitor->getNewsletterUser()->getEmail());
        if ($dbProgenitor === null) {
            $progenitor->setUsername($progenitor->getNewsletterUser()->getEmail());
            $progenitor->setEmail($progenitor->getNewsletterUser()->getEmail());
            $progenitor->setPlainPassword('kinder2');
            $progenitor->setEnabled(true);
            $token = sha1(uniqid(mt_rand(), true)); // Or whatever you prefer to generate a token
            $progenitor->setConfirmationToken($token);

            $this->em->persist($progenitor);
            $this->em->flush();
            $mailer->sendConfirmationEmailMessage($progenitor);
            return $progenitor->getId();
        }
        return;
    }
}
