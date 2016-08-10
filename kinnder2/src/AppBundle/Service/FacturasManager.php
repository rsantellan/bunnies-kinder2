<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Entity\Horario;
use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\FacturaEstudiante;
use AppBundle\Entity\FacturaEstudianteDetalle;
use AppBundle\Entity\FacturaFinal;
use AppBundle\Entity\FacturaFinalDetalle;

/**
 * Description of FacturasManager.
 *
 * @author Rodrigo Santellan
 */
class FacturasManager
{
    protected $em;

    protected $logger;

    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->logger->addDebug('Starting facturas manager');
    }

    public function generateUserBill(Estudiante $estudiante, $month = null, $year = null, $ignorePaidAndCancel = false)
    {
        if ($month === null) {
            $month = date('n');
        }
        if ($year === null) {
            $year = date('Y');
        }
        if ($estudiante->getEgresado()) {
            $this->logger->addInfo(sprintf('The student %s has already left', $estudiante->getId()));

            return;
        }

        $factura = $this->em->getRepository('AppBundle:FacturaEstudiante')->retrieveFacturaOfEstudiantePerMonthAndYear($estudiante, $month, $year);
        if ($factura) {
            if(!$ignorePaidAndCancel){
                if ($factura->getPago()) {
                    $this->logger->addInfo(sprintf('The student %s has the bill of %s/%s paid', $estudiante->getId(), $month, $year));

                    return;
                }
                if ($factura->getCancelado()) {
                    $this->logger->addInfo(sprintf('The student %s has the bill of %s/%s cancelled', $estudiante->getId(), $month, $year));

                    return;
                }                
            }
        } else {
            $factura = new FacturaEstudiante();
        }
        if ($estudiante->getAnioIngreso() > date('Y')) {
            if ($factura->getId() > 0) {
                $this->em->remove($factura);
                $this->em->flush($factura);
            }
            $this->logger->addInfo(sprintf('The student %s starting year is %s. No bill generated', $estudiante->getId(), $estudiante->getAnioIngreso()));

            return;
        }
        $factura->setEstudiante($estudiante);
        $factura->setMonth($month);
        $factura->setTotal(0);
        $factura->setYear($year);
        $factura->setFechavencimiento(new \DateTime());
        $this->em->persist($factura);
        $total = 0;
        $listadoDetalles = array();
        if ($estudiante->getHorario() !== null) {
            $costoHorario = $this->getCostoOfHorario($estudiante->getHorario());
            $total = $costoHorario;
            $detalleMensualidad = new FacturaEstudianteDetalle();
            $detalleMensualidad->setAmount($costoHorario);
            $detalleMensualidad->setDescription('Mensualidad');
            $detalleMensualidad->setFactura($factura);
            $detalleMensualidad->setAutogenerated(true);
            $listadoDetalles[$detalleMensualidad->generateUniqueHash()] = $detalleMensualidad;
        }
        // Descuento de hermano
        $activeBrother = 0;

        foreach ($estudiante->getMyBrothers() as $brother) {
            if (!$brother->getEgresado()) {
                ++$activeBrother;
            }
        }
        $descuento = $this->em->getRepository('AppBundle:Descuento')->findOneBy(array('cantidadDeHermanos' => $activeBrother));
        if ($descuento && $descuento->getPorcentaje() > 0) {
            $amount = ceil((($total * $descuento->getPorcentaje()) / 100) * -1);
            $detalleDescuentoHermano = new FacturaEstudianteDetalle();
            $detalleDescuentoHermano->setAmount($amount);
            $detalleDescuentoHermano->setDescription('Descuento hermano');
            $detalleDescuentoHermano->setFactura($factura);
            $detalleDescuentoHermano->setAutogenerated(true);
            $listadoDetalles[$detalleDescuentoHermano->generateUniqueHash()] = $detalleDescuentoHermano;
            $total += $amount;
        }
        if ($estudiante->getDescuento() && $estudiante->getDescuento() > 0) {
            $amount = ceil((($total * $estudiante->getDescuento()) / 100) * -1);
            $detalleDescuento = new FacturaEstudianteDetalle();
            $detalleDescuento->setAmount($amount);
            $detalleDescuento->setDescription('Descuento usuario');
            $detalleDescuento->setFactura($factura);
            $detalleDescuento->setAutogenerated(true);
            $listadoDetalles[$detalleDescuento->generateUniqueHash()] = $detalleDescuento;
            $total += $amount;
        }
        foreach ($estudiante->getActividades() as $actividad) {
            $detalleActividad = new FacturaEstudianteDetalle();
            $detalleActividad->setAmount($actividad->getCosto());
            $detalleActividad->setDescription($actividad->getNombre());
            $detalleActividad->setFactura($factura);
            $detalleActividad->setAutogenerated(true);
            $listadoDetalles[$detalleActividad->generateUniqueHash()] = $detalleActividad;
            $total += $actividad->getCosto();
        }
        foreach ($factura->getFacturaDetalles() as $detalle) {
            if (count($listadoDetalles) > 0) {
                $auxDetalle = array_pop($listadoDetalles);
                $detalle->setAmount($auxDetalle->getAmount());
                $detalle->setDescription($auxDetalle->getDescription());
                $this->em->persist($detalle);
            } else {
                $this->em->remove($detalle);
            }
        }
        foreach ($listadoDetalles as $detalle) {
            $this->em->persist($detalle);
        }
        $factura->setTotal($total);
        $this->em->persist($factura);
        $this->em->flush();
    }

    public function getCostoOfHorario(Horario $horario)
    {
        $costo = $this->em->getRepository('AppBundle:Costos')->getCostoValue();
        $returnCosto = 0;
        switch ($horario->getDbname()) {
          case 'matutino':
            $returnCosto = $costo->getMatutino();
            break;
          case 'doble_horario':
            $returnCosto = $costo->getDobleHorario();
            break;
          case 'vespertino':
            $returnCosto = $costo->getVespertino();
            break;
          default:
            break;
        }

        return $returnCosto;
    }

    public function createDetalleFacturaUsuario(Estudiante $estudiante, $month, $year, $description, $amount)
    {
        if($estudiante === null){
            throw new \Exception('Student is null');
        }
        $factura = $this->em->getRepository('AppBundle:FacturaEstudiante')->retrieveFacturaOfEstudiantePerMonthAndYear($estudiante, $month, $year);
        $detalle = new FacturaEstudianteDetalle();
        $detalle->setAmount($amount);
        $detalle->setDescription($description);
        $detalle->setFactura($factura);
        $detalle->setAutogenerated(false);
        $factura->setTotal($factura->getTotal() + $amount);
        $this->em->persist($detalle);
        $this->em->persist($factura);
        $this->em->flush();
        $returnData = $this->generateFinalBill($estudiante->getCuenta(), $month, $year);
        $this->em->refresh($returnData);

        return $returnData;
    }

    public function resetDetalleFacturaFinal(FacturaFinal $factura, $returnFullData = false)
    {
        foreach ($factura->getFacturasEstudiantes() as $facturaEstudiante) {
            foreach ($facturaEstudiante->getFacturaDetalles() as $detalle) {
                if (!$detalle->getAutogenerated()) {
                    $this->em->remove($detalle);
                }
            }
        }
        $this->em->flush();
        $returnData = $this->generateFinalBill($factura->getCuenta(), $factura->getMonth(), $factura->getYear());
        $this->em->refresh($returnData);
        if(!$returnFullData){
            return $returnData;
        }else{
            $result = true;
            $message = 'Factura reseteado al estado original';
            $cuentaId = $factura->getCuenta()->getId();
            $amount = $factura->getCuenta()->getFormatedDiferencia();
            $positive = false;
            if ($factura->getCuenta()->getDiferencia() < 0) {
                $positive = true;
            }
            return array(
                'result' => $result,
                'html' => $html,
                'message' => $message,
                'amount' => $amount,
                'positive' => $positive,
                'cuentaId' => $cuentaId,
                'facturaId' => $facturaId,
                'factura' => $factura,
            );
        }

    }

    public function generateFinalBill(Cuenta $cuenta, $month = null, $year = null, $ignorePaidAndCancel = false)
    {
        if ($month === null) {
            $month = date('n');
        }
        if ($year === null) {
            $year = date('Y');
        }
        $factura = $this->em->getRepository('AppBundle:FacturaFinal')->retrieveFacturaFinalOfAccountPerMonthAndYear($cuenta, $month, $year);
        $pagoDelTotal = 0;
        if ($factura) {
            if(!$ignorePaidAndCancel){
                if ($factura->getPago()) {
                    $this->logger->addInfo(sprintf('The account %s has the bill of %s/%s paid', $cuenta->getId(), $month, $year));

                    return $factura;
                }
                if ($factura->getCancelado()) {
                    $this->logger->addInfo(sprintf('The account %s has the bill of %s/%s cancelled', $cuenta->getId(), $month, $year));

                    return $factura;
                }
            }
            
            $pagoDelTotal = $factura->getPagadodeltotal();
            $this->logger->addInfo(sprintf('The account %s has the bill of %s/%s resting to debt. Debt: %s , bill old total: %s. ZZZAAA', $cuenta->getId(), $month, $year, $cuenta->getDebe(), $factura->getTotal()));
            $cuenta->setDebe($cuenta->getDebe() - $factura->getTotal());
        } else {
            $factura = new FacturaFinal();
            $factura->setCuenta($cuenta);
        }
        $total = 0;
        $factura->setTotal($total);
        $factura->setFechavencimiento(new \DateTime());
        $factura->setPagadodeltotal($pagoDelTotal);
        $factura->setMonth($month);
        $factura->setYear($year);
        $this->em->persist($factura);

        $facturasEstudiantes = $this->em->getRepository('AppBundle:FacturaEstudiante')->retrieveFacturaOfEstudiantePerAccountMonthAndYear($cuenta, $month, $year);
        $studentsQuantity = count($facturasEstudiantes);
        $listadoDetalles = array();
        foreach ($facturasEstudiantes as $facturaEstudiante) {
            $this->em->refresh($facturaEstudiante);
            foreach ($facturaEstudiante->getFacturaDetalles() as $detalle) {
                $facturaFinalDetalle = new FacturaFinalDetalle();
                $facturaFinalDetalle->setAmount($detalle->getAmount());
                $facturaFinalDetalle->setFactura($factura);
                $total += $detalle->getAmount();
                $descripcion = '';
                if ($studentsQuantity > 1) {
                    $descripcion = sprintf('[%s] %s', $facturaEstudiante->getEstudiante()->getNombre(), $detalle->getDescription());
                } else {
                    $descripcion = $detalle->getDescription();
                }
                $facturaFinalDetalle->setDescription($descripcion);
                $listadoDetalles[] = $facturaFinalDetalle;
            }
            $facturaEstudiante->setFacturaFinal($factura);
            $this->em->persist($facturaEstudiante);
        }
        foreach ($factura->getFacturaFinalDetalles() as $detalle) {
            if (count($listadoDetalles) > 0) {
                $auxDetalle = array_pop($listadoDetalles);
                $detalle->setAmount($auxDetalle->getAmount());
                $detalle->setDescription($auxDetalle->getDescription());
                $this->em->persist($detalle);
            } else {
                $this->em->remove($detalle);
            }
        }
        foreach ($listadoDetalles as $detalle) {
            $this->em->persist($detalle);
        }
        if ($total > 0 && $total <= $pagoDelTotal) {
            $factura->setPago(true);
        }
        $factura->setTotal($total);
        $this->em->persist($factura);
        $cuenta->setDebe($cuenta->getDebe() + $factura->getTotal());
        $this->em->persist($cuenta);
        $this->em->flush();

        return $factura;
    }

    public function generateUserAndFinalBill(Estudiante $estudiante, $month = null, $year = null, $ignorePaidAndCancel = false)
    {
        $this->generateUserBill($estudiante, $month, $year, $ignorePaidAndCancel);
        $this->generateFinalBill($estudiante->getCuenta(), $month, $year, $ignorePaidAndCancel);
    }

    public function cancelFactura(FacturaFinal $factura)
    {
        if ($factura->getCancelado() && $factura->getPago()) {
            return;
        }
        $cuenta = $factura->getCuenta();
        $cuenta->setDebe($cuenta->getDebe() - $factura->getTotal());
        $factura->setCancelado(true);
        foreach ($factura->getFacturasEstudiantes() as $facturaEstudiante) {
            $facturaEstudiante->setCancelado(true);
            $this->em->persist($facturaEstudiante);
        }
        $this->em->persist($factura);
        $this->em->persist($cuenta);
        $this->em->flush();
    }
}
