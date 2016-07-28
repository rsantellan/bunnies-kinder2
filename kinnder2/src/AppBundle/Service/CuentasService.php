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

    

    public function disableFactura($id)
    {
        $factura = $this->em->getRepository('AppBundle:FacturaFinal')->find($id);
        if (!$factura) {
            return;
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
            return;
        }
        if ($factura->getCancelado()) {
            $factura->setCancelado(false);
            $cuenta = $factura->getCuenta();
            $cuenta->addDebeAmount($factura->getTotal());
            $this->em->persist($factura);
            $this->em->persist($cuenta);
            $this->em->flush();
          // Reviso si esa factura puede estar paga
          if ($cuenta->getDiferencia() <= 0) {
              $factura->setPago(true);
              $this->em->persist($factura);
              $this->em->flush();
          }
        }

        return $factura;
    }

    public function resetDetalleFactura()
    {

    }

    public function listCuentasGrouped()
    {
        $accounts = $this->em->getRepository('AppBundle:Cuenta')->retrieveAllWithUsersAndParents();

        $data = array(
            'negative' => array(),
            'positive' => array(),
            'zero' => array(),
        );
        foreach ($accounts as $account) {
            if ($account->getDiferencia() == 0) {
                $data['zero'][] = $account;
            } else {
                if ($account->getDiferencia() > 0) {
                    $data['positive'][] = $account;
                } else {
                    $data['negative'][] = $account;
                }
            }
        }
        return $data;
    }
}
