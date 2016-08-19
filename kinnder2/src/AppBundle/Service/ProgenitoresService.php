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

    public function addStudentToProgenitor($progenitorId, $studentId){
        $progenitor = $this->em->getRepository('AppBundle:Progenitor')->find($progenitorId);
        $estudiante = $this->em->getRepository('AppBundle:Estudiante')->find($studentId);
        if (!$progenitor) {
            throw new \Exception('No se pudo encontrar al padre seleccionado.');
        }
        if (!$estudiante) {
            throw new \Exception('No se pudo encontrar al estudiante seleccionado.');
        }
        $referenciaBancaria = $estudiante->getCuenta()->getReferenciabancaria(); 
        foreach($progenitor->getEstudiantes() as $oldStudent){
            if($oldStudent->getCuenta()->getReferenciabancaria() != $referenciaBancaria){
                throw new \Exception("Este padre ya tiene un hijo asignado con otra referencia bancaria");
            }
        }
        $progenitor->addEstudiante($estudiante);
        $estudiante->addProgenitore($progenitor);
        $progenitor->setCuenta($estudiante->getCuenta());
        $this->em->persist($estudiante);
        $this->em->persist($progenitor);
        $this->em->flush();
        return $progenitor;
    }

    public function removeStudentsFromProgenitor($progenitorId){
        $progenitor = $this->em->getRepository('AppBundle:Progenitor')->find($progenitorId);
        if (!$progenitor) {
            throw new \Exception('No se pudo encontrar al padre seleccionado.');
        }
        $estudiantes = $progenitor->getEstudiantes();
        foreach($estudiantes as $estudiante){
            $progenitor->getEstudiantes()->removeElement($estudiante);
            $estudiante->removeProgenitore($progenitor);
            $this->em->persist($estudiante);
        }
        $progenitor->removeCuenta();
        $this->em->persist($progenitor);
        $this->em->flush();
        return $progenitor;
    }
}
