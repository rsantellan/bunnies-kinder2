<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\Form\Form;

use AppBundle\Entity\Cobro;


/**
 * Description of CobroService.
 *
 * @author Rodrigo Santellan
 */
class CobroService
{
    protected $em;

    protected $logger;

    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->logger->addDebug('Starting cobros service');
    }

    public function saveCobroForm(Form $form, Cobro $cobro, $cuentaId)
    {
        $cuenta = $this->em->getRepository('AppBundle:Cuenta')->find($cuentaId);
        $result = false;
        $message = 'Ocurrion un error al guardar el cobro.';
        $amount = 0;
        $positive = false;
        if ($cuenta && $form->isValid()) {
            $cobro->setCuenta($cuenta);
            $this->em->persist($cobro);
            $cuenta->addPagoAmount($cobro->getMonto());
            $this->em->persist($cuenta);
            $this->em->flush();
            $result = true;
            $message = 'Cobro guardado con exito.';
            if ($cobro->getEnviado()) {
                //send email
                $message .= ' Email enviado correctamente';
            }
            $amount = $cuenta->getFormatedDiferencia();
            if ($cuenta->getDiferencia() < 0) {
                $positive = true;
            }
        }
        return array(
            'result' => $result,
            'message' => $message,
            'amount' => $amount,
            'positive' => $positive,
            'cuentaId' => $cuentaId,
            'cobro' => $cobro,
        );
    }

    public function disableCobro($id)
    {
        $cobro = $this->em->getRepository('AppBundle:Cobro')->find($id);
        if (!$cobro) {
            return;
        }
        $facturasForRefresh = array();
        if (!$cobro->getCancelado()) {
            $cobro->setCancelado(true);
            $cuenta = $cobro->getCuenta();
            $cuenta->removePagoAmount($cobro->getMonto());
            $this->em->persist($cobro);
            $this->em->persist($cuenta);
            $this->em->flush();

            if ($cuenta->getDiferencia() > 0) {
                $facturas = $this->em->getRepository('AppBundle:FacturaFinal')->retrievePaidFacturasOfAccount($cuenta->getId());
                $monto = $cobro->getMonto();
                foreach ($facturas as $factura) {
                    if ($monto > 0) {
                        $monto = $monto - $factura->getTotal();
                        $factura->setPagadodeltotal(0);
                        $factura->setPago(false);
                        $this->em->persist($factura);
                        $this->em->flush($factura);
                        $facturasForRefresh[] = $factura;
                    }
                }
            }
        }

        $amount = $cobro->getCuenta()->getFormatedDiferencia();
        $positive = false;
        if ($cobro->getCuenta()->getDiferencia() < 0) {
            $positive = true;
        }
        $message = 'Cobro cancelado con exito';
        return array(
            'cobro' => $cobro,
            'facturas' => $facturasForRefresh,
            'message' => $message,
            'positive' => $positive,
            'amount' => $amount,
        );
    }

    public function enableCobro($id)
    {
        $cobro = $this->em->getRepository('AppBundle:Cobro')->find($id);
        if (!$cobro) {
            return;
        }
        $facturasForRefresh = array();
        if ($cobro->getCancelado()) {
            $cobro->setCancelado(false);
            $cuenta = $cobro->getCuenta();
            $cuenta->addPagoAmount($cobro->getMonto());
            $this->em->persist($cobro);
            $this->em->persist($cuenta);
            $this->em->flush();
            $facturas = $this->em->getRepository('AppBundle:FacturaFinal')->retrieveUnpaidFacturasOfAccount($cuenta->getId(), false);
            $monto = $cobro->getMonto();
            foreach ($facturas as $factura) {
                if ($monto > 0) {
                    $monto = $monto - $factura->getTotal();
                    $factura->setPagadodeltotal(0);
                    $factura->setPago(true);
                    $this->em->persist($factura);
                    $this->em->flush($factura);
                    $facturasForRefresh[] = $factura;
                }
            }
        }
        $amount = $cobro->getCuenta()->getFormatedDiferencia();
        $positive = false;
        if ($cobro->getCuenta()->getDiferencia() < 0) {
            $positive = true;
        }
        $message = 'Cobro activado con exito';
        return array(
            'cobro' => $cobro,
            'facturas' => $facturasForRefresh,
            'message' => $message,
            'positive' => $positive,
            'amount' => $amount,
      );
    }
}
