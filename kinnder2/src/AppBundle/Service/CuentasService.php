<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\Cobro;

/**
 * Description of CuentasService.
 *
 * @author Rodrigo Santellan
 */
class CuentasService
{
    protected $em;

    protected $logger;

    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->logger->addDebug('Starting cuentas service');
    }

    public function updateOrCreateCuenta(Estudiante $estudiante)
    {
        $cuenta = $this->em->getRepository('AppBundle:Cuenta')->findOneBy(array('referenciabancaria' => $estudiante->getReferenciaBancaria()));

        if ($cuenta) {
            foreach ($cuenta->getEstudiantes() as $hermano) {
                $estudiante->addMyBrother($hermano);
                $hermano->addMyBrother($estudiante);
                $this->em->persist($hermano);
            }
            foreach ($cuenta->getProgenitores() as $progenitor) {
                $estudiante->addProgenitore($progenitor);
                $progenitor->addEstudiante($estudiante);
                $this->em->persist($progenitor);
            }
            $estudiante->setCuenta($cuenta);
            $this->em->persist($estudiante);
        } else {
            $this->logger->addDebug(sprintf('Account not exists. Creating with reference: %s', $estudiante->getReferenciaBancaria()));
            $cuenta = new Cuenta();
            $cuenta->setReferenciabancaria($estudiante->getReferenciaBancaria());
            $this->em->persist($cuenta);
            $estudiante->setCuenta($cuenta);
        }
        $this->em->persist($estudiante);
        $this->em->flush();
    }

    public function addCobroToCuenta(Cuenta $cuenta, $amount, \DateTime $paymentDate)
    {
        $cobro = new Cobro();
        $cobro->setMonto($amount);
        $cobro->setFecha($paymentDate);
        $cobro->setCuenta($cuenta);
        $cuenta->setPago($cuenta->getPago() + $amount);
        $this->em->persist($cobro);
        $this->em->persist($cuenta);
        $this->em->flush();
    }

    public function disableCobro($id)
    {
      $cobro = $this->em->getRepository('AppBundle:Cobro')->find($id);
      if(!$cobro){
        return null;
      }
      if (!$cobro->getCancelado()) {
          $cobro->setCancelado(true);
          $cuenta = $cobro->getCuenta();
          $cuenta->removePagoAmount($cobro->getMonto());
          $this->em->persist($cobro);
          $this->em->persist($cuenta);
          $this->em->flush();
      }
      return $cobro;
    }

    public function enableCobro($id)
    {
      $cobro = $this->em->getRepository('AppBundle:Cobro')->find($id);
      if(!$cobro){
        return null;
      }
      if ($cobro->getCancelado()) {

          $cobro->setCancelado(false);
          $cuenta = $cobro->getCuenta();
          $cuenta->addPagoAmount($cobro->getMonto());
          $this->em->persist($cobro);
          $this->em->persist($cuenta);
          $this->em->flush();
      }
      return $cobro;
    }

    public function disableFactura($id)
    {
      $factura = $this->em->getRepository('AppBundle:FacturaFinal')->find($id);
      if (!$factura) {
          return null;
      }
      if (!$factura->getCancelado()) {
          $factura->setCancelado(true);
          $factura->setPagadodeltotal(0);
          $factura->setPago(false);
          $cuenta = $factura->getCuenta();
          $cuenta->removeDebeAmount($factura->getTotal());
          $this->em->persist($factura);
          $this->em->persist($cuenta);
          $this->em->flush();
      }
      return $factura;
    }

    public function enableFactura($id)
    {
      $factura = $this->em->getRepository('AppBundle:FacturaFinal')->find($id);
      if (!$factura) {
          return null;
      }
      if ($factura->getCancelado()) {
          $factura->setCancelado(false);
          $cuenta = $factura->getCuenta();
          $cuenta->addDebeAmount($factura->getTotal());
          $this->em->persist($factura);
          $this->em->persist($cuenta);
          $this->em->flush();
          // Reviso si esa factura puede estar paga
          if($cuenta->getDiferencia() <  $factura->getTotal()){
            if(( $factura->getTotal() - $cuenta->getDiferencia()) <= 0){
              
            }
          }
      }
      return $factura;
    }
}
