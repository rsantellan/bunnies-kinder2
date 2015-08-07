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
 * Description of FacturasManager
 *
 * @author Rodrigo Santellan
 */
class FacturasManager {
  
  protected $em;
  
  protected $logger;
  
  function __construct(EntityManager $em, Logger $logger) {
    $this->em = $em;
    $this->logger = $logger;
    $this->logger->addDebug("Starting facturas manager");
  }

  function generateUserBill(Estudiante $estudiante, $month = null, $year = null){
    if($month == null){
      $month = date('n');
    }
    if($year == null){
      $year = date('Y');
    }
    if($estudiante->getEgresado()){
      $this->logger->addInfo(sprintf('The student %s has already left', $estudiante->getId()));
      return;
    }
    
    $factura = $this->em->getRepository('AppBundle:FacturaEstudiante')->retrieveFacturaOfEstudiantePerMonthAndYear($estudiante, $month, $year);
    if($factura)
    {
      if($factura->getPago())
      {
        $this->logger->addInfo(sprintf('The student %s has the bill of %s/%s paid', $estudiante->getId(), $month, $year));
        return;
      }
      if($factura->getCancelado())
      {
        $this->logger->addInfo(sprintf('The student %s has the bill of %s/%s cancelled', $estudiante->getId(), $month, $year));
        return;
      }
      //$this->em->remove($factura);
      //$this->em->flush($factura);
    }
    else
    {
      $factura = new FacturaEstudiante();
    }
    if($estudiante->getAnioIngreso() > date('Y'))
    {
      if($factura->getId() > 0)
      {
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
    
    $costoHorario = $this->getCostoOfHorario($estudiante->getHorario());
    $total = $costoHorario;
    $listadoDetalles = array();
    
    $detalleMensualidad = new FacturaEstudianteDetalle();
    $detalleMensualidad->setAmount($costoHorario);
    $detalleMensualidad->setDescription('Mensualidad');
    $detalleMensualidad->setFactura($factura);
    $listadoDetalles[] = $detalleMensualidad;
    //$this->em->persist($detalleMensualidad);
    
    // Descuento de hermano
    $activeBrother = 0;
    
    foreach($estudiante->getBrothersWithMe() as $brother)
    {
      if(!$brother->getEgresado())
      {
        $activeBrother++;
      }
    }
    $descuento = $this->em->getRepository('AppBundle:Descuento')->findOneBy(array('cantidadDeHermanos' => $activeBrother));
    if($descuento && $descuento->getPorcentaje() > 0)
    {
      $amount = (($total * $descuento->getPorcentaje()) / 100) * -1;
      $detalleDescuentoHermano = new FacturaEstudianteDetalle();
      $detalleDescuentoHermano->setAmount($amount);
      $detalleDescuentoHermano->setDescription('Descuento hermano');
      $detalleDescuentoHermano->setFactura($factura);
      $listadoDetalles[] = $detalleDescuentoHermano;
      //$this->em->persist($detalleDescuentoHermano);
      $total += $amount;
    }
    if($estudiante->getDescuento() && $estudiante->getDescuento() > 0)
    {
      $amount = (($total * $estudiante->getDescuento()) / 100) * -1;
      $detalleDescuento = new FacturaEstudianteDetalle();
      $detalleDescuento->setAmount($amount);
      $detalleDescuento->setDescription('Descuento usuario');
      $detalleDescuento->setFactura($factura);
      //$this->em->persist($detalleDescuento);
      $listadoDetalles[] = $detalleDescuento;
      $total += $amount;
    }
    foreach($estudiante->getActividades() as $actividad)
    {
      $detalleActividad = new FacturaEstudianteDetalle();
      $detalleActividad->setAmount($actividad->getCosto());
      $detalleActividad->setDescription($actividad->getNombre());
      $detalleActividad->setFactura($factura);
      //$this->em->persist($detalleActividad);
      $listadoDetalles[] = $detalleActividad;
      $total += $actividad->getCosto();
    }
    
    foreach($factura->getFacturaDetalles() as $detalle)
    {
      if(count($listadoDetalles) > 0)
      {
        $auxDetalle = array_pop($listadoDetalles);
        $detalle->setAmount($auxDetalle->getAmount());
        $detalle->setDescription($auxDetalle->getDescription());
        $this->em->persist($detalle);
      }
      else
      {
        $this->em->remove($detalle);
      }
    }
    foreach($listadoDetalles as $detalle)
    {
      $this->em->persist($detalle);
    }
    $factura->setTotal($total);
    $this->em->persist($factura);
    $this->em->flush();
    //$this->em->clear();
  }
  
  public function getCostoOfHorario(Horario $horario){
    $costo = $this->em->getRepository('AppBundle:Costos')->getCostoValue();
    $returnCosto = 0;
    switch ($horario->getDbname()) 
    {
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
  
  
  public function generateFinalBill(Cuenta $cuenta, $month = null, $year = null)
  {
    if($month == null){
      $month = date('n');
    }
    if($year == null){
      $year = date('Y');
    }
    $factura = $this->em->getRepository('AppBundle:FacturaFinal')->retrieveFacturaFinalOfAccountPerMonthAndYear($cuenta, $month, $year);
    $pagoDelTotal = 0;
    if($factura)
    {
      if($factura->getPago())
      {
        $this->logger->addInfo(sprintf('The account %s has the bill of %s/%s paid', $cuenta->getId(), $month, $year));
        return;
      }
      if($factura->getCancelado())
      {
        $this->logger->addInfo(sprintf('The account %s has the bill of %s/%s cancelled', $cuenta->getId(), $month, $year));
        return;
      }
      $pagoDelTotal = $factura->getPagadodeltotal();
      $cuenta->setDebe($cuenta->getDebe() - $factura->getTotal());
      //$this->em->remove($factura);
      //$this->em->flush($factura);
    }
    else
    {
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
    foreach($facturasEstudiantes as $facturaEstudiante)
    {
      $this->em->refresh($facturaEstudiante);
      foreach($facturaEstudiante->getFacturaDetalles() as $detalle)
      {
        $facturaFinalDetalle = new FacturaFinalDetalle();
        $facturaFinalDetalle->setAmount($detalle->getAmount());
        $facturaFinalDetalle->setFactura($factura);
        $total += $detalle->getAmount();
        $descripcion = '';
        if($studentsQuantity > 1)
        {
          $descripcion = sprintf('[%s] %s', $facturaEstudiante->getEstudiante()->getNombre() , $detalle->getDescription());
        }
        else
        {
          $descripcion = $detalle->getDescription();
        }
        $facturaFinalDetalle->setDescription($descripcion);
        $listadoDetalles[] = $facturaFinalDetalle;
      }
      //$factura->addFacturaEstudiante($facturaEstudiante);
      $facturaEstudiante->setFacturaFinal($factura);
      $this->em->persist($facturaEstudiante);
    }
    foreach($factura->getFacturaFinalDetalles() as $detalle)
    {
      if(count($listadoDetalles) > 0)
      {
        $auxDetalle = array_pop($listadoDetalles);
        $detalle->setAmount($auxDetalle->getAmount());
        $detalle->setDescription($auxDetalle->getDescription());
        $this->em->persist($detalle);
      }
      else
      {
        $this->em->remove($detalle);
      }
    }
    foreach($listadoDetalles as $detalle)
    {
      $this->em->persist($detalle);
    }
    if($total > 0 && $total <= $pagoDelTotal)
    {
      $factura->setPago(true);
    }
    $factura->setTotal($total);
    $this->em->persist($factura);
    $cuenta->setDebe($cuenta->getDebe() + $factura->getTotal());
    $this->em->persist($cuenta);
    $this->em->flush();
  }
  
  
  public function generateUserAndFinalBill(Estudiante $estudiante, $month = null, $year = null)
  {
    $this->generateUserBill($estudiante, $month, $year);
    $this->generateFinalBill($estudiante->getCuenta(), $month, $year);
  }
}
