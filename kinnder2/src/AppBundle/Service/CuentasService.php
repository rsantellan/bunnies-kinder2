<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;

use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\Cobro;

/**
 * Description of CuentasService
 *
 * @author Rodrigo Santellan
 */
class CuentasService {
  
  protected $em;
  
  protected $logger;
  
  function __construct(EntityManager $em, Logger $logger) {
    $this->em = $em;
    $this->logger = $logger;
    $this->logger->addDebug("Starting cuentas service");
  }

  function updateOrCreateCuenta(Estudiante $estudiante)
  {
    $cuenta = $this->em->getRepository('AppBundle:Cuenta')->findOneBy(array('referenciabancaria' => $estudiante->getReferenciaBancaria()));
            
    if($cuenta){
      foreach($cuenta->getEstudiantes() as $hermano)
      {
        $estudiante->addMyBrother($hermano);
        $hermano->addMyBrother($estudiante);
        $this->em->persist($hermano);
      }
      foreach($cuenta->getProgenitores() as $progenitor){
        $estudiante->addProgenitore($progenitor);
        $progenitor->addEstudiante($estudiante);
        $this->em->persist($progenitor);
      }
      $estudiante->setCuenta($cuenta);
      $this->em->persist($estudiante);  
    }else{
      $this->logger->addDebug(sprintf('Account not exists. Creating with reference: %s', $estudiante->getReferenciaBancaria()));
      $cuenta = new Cuenta();
      $cuenta->setReferenciabancaria($estudiante->getReferenciaBancaria());
      $this->em->persist($cuenta);
      $estudiante->setCuenta($cuenta);
    }
    $this->em->persist($estudiante);
    $this->em->flush();
  }
  
  function addCobroToCuenta(Cuenta $cuenta, $amount, \DateTime $paymentDate)
  {
    $cobro = new Cobro();
    $cobro->setMonto($amount);
    $cobro->setFecha($paymentDate);
    $cobro->setCuenta($cuenta);
    $this->em->persist($cobro);
    $this->em->flush();
  }
}
