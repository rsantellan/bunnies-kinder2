<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Fpdf\Invoice;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\Cobro;
use AppBundle\Entity\FacturaFinalDetalle;

/**
 * Description of PdfManager.
 *
 * @author Rodrigo Santellan
 */
class PdfManager
{
    protected $em;
    protected $logger;
    protected $webDirectory;

    public function __construct(EntityManager $em, Logger $logger, $rootDir)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->webDirectory = $rootDir.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'web'.DIRECTORY_SEPARATOR;
        $this->logger->addDebug('Starting pdf manager');
    }

    public function exportCobroToPdf(Cobro $cobro, Cuenta $account = null, $location = null)
    {
        if ($account === null) {
            $account = $cobro->getCuenta();
        }
        $alumnos = '';
        $apellido = '';
        foreach ($account->getEstudiantes() as $estudiante) {
            $alumnos .= $estudiante->getNombre().',';
            $apellido = $estudiante->getApellido();
        }
        if (strlen($alumnos) > 0) {
            $alumnos = rtrim($alumnos, ',');
        }

        $padres = '';
        foreach ($account->getProgenitores() as $progenitor) {
            $padres .= $progenitor->getNombre().' '.',';
        }
        if (strlen($padres) > 0) {
            $padres = rtrim($padres, ',');
        }
        $pdf = new Invoice(20, 'P', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->addSociete($this->webDirectory.'bundles/app/img/logo.png');
        $pdf->temporaire("Bunny's Kinder");
        $pdf->addDate(date('d/m/Y'));
        $pdf->addClient($account->getReferenciabancaria());
        $pdf->addAlumnos($alumnos);
        $pdf->addPadres($padres);
        $colsNumbers = array('Item' => 30,
              'Descripción' => 130,
               'Precio' => 30,
              );
        $pdf->addCols($colsNumbers);
        $cols = array('Item' => 'C',
              'Descripción' => 'C',
               'Precio' => 'C',
               );
        $pdf->addLineFormat($cols);
        $y = 70;
        $size = 0;
        $counterItems = 1;

        $linea = array(
          'Item' => $counterItems,
          'Descripción' => sprintf('Pago en la fecha: %s', $cobro->getFecha()->format('d/m/Y')),
          'Precio' => '$'.number_format($cobro->getMonto(), 0, ',', '.'),
        );
        $size = $pdf->addLine($y, $linea);
        $y   += $size + 2;
        ++$counterItems;
        $pdf->addCadreEurosFrancs('$ '.number_format($cobro->getMonto(), 0, ',', '.'));
        $outputOption = 'I';
        if ($location !== null) {
            if (!is_dir($location)) {
                $location = sys_get_temp_dir();
            }
            $outputOption = 'F';
            $location .= DIRECTORY_SEPARATOR;
        } else {
            $location = '';
        }
        $outputName = sprintf('Cobro-%s-%s.pdf', $account->getReferenciabancaria(), date('m-Y'));
        $pdf->Output($location.$outputName, $outputOption);
        if ($outputOption == 'F') {
            return $location.$outputName;
        }
    }

    public function exportAccountToPdf(Cuenta $account, $location = null)
    {
        $alumnos = '';
        $apellido = '';
        foreach ($account->getEstudiantes() as $estudiante) {
            $alumnos .= $estudiante->getNombre().',';
            $apellido = $estudiante->getApellido();
        }
        if (strlen($alumnos) > 0) {
            $alumnos = rtrim($alumnos, ',');
        }

        $padres = '';
        foreach ($account->getProgenitores() as $progenitor) {
            $padres .= $progenitor->getNombre().' '.',';
        }
        if (strlen($padres) > 0) {
            $padres = rtrim($padres, ',');
        }

        $pdf = new Invoice(20, 'P', 'mm', 'A4');
        $facturas = $this->em->getRepository('AppBundle:FacturaFinal')->retrieveUnpaidFacturasOfAccount($account->getId());
        $cantidadFacturasDetalles = 0;
        $facturasDetailList = array();
        $quantity = count($facturas);
        $meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
        $montoAdeudado = $account->getDiferencia();
        $lineDeuda = null;
        $montoFacturaMes = 0;
        foreach ($facturas as $factura) {
            if ($factura->getYear() == date('Y') && $factura->getMonth() == date('m')) {
                foreach ($factura->getFacturaFinalDetalles() as $facturaDetalle) {
                    if ($quantity > 1) {
                        $description = sprintf('%s (%s %s)', $facturaDetalle->getDescription(), $meses[$factura->getMonth() - 1], $factura->getYear());
                        $facturaDetalle->setDescription($description);
                    }
                    $facturasDetailList[$cantidadFacturasDetalles] = $facturaDetalle;
                    ++$cantidadFacturasDetalles;
                }
                if ($quantity > 1) {
                    $facturasDetailList[$cantidadFacturasDetalles] = new FacturaFinalDetalle();
                    ++$cantidadFacturasDetalles;
                }
                $montoFacturaMes = ((float) $factura->getTotal()) - ((float) $factura->getPagadodeltotal());
            }
        }
        if($montoFacturaMes < $account->getDiferencia())
        {
            $montoAdeudado = (float) $montoAdeudado - $montoFacturaMes;
            $precion = number_format(1 * (int) ($montoAdeudado), 0, ',', '.');
            $texto = sprintf('Monto adeudado al %s', date('m-Y'));
            $lineDeuda = array(
              'Item' => 1,
              'Descripción' => $texto,
              'Precio' => '$'.$precion,
          );
        }
        $maxPerPage = 30;
        $cantidadPaginas = $cantidadFacturasDetalles / $maxPerPage;
        $showPages = true;
        if ($cantidadPaginas < 1) {
            $showPages = false;
        }
        if ($cantidadFacturasDetalles > 0) {
            $cantidadFacturasDetalles = 0;
        }

        $pagina = 1;
        $paymentQuantity = 0;
        while ($cantidadPaginas >= 0 && $cantidadFacturasDetalles <= count($facturasDetailList)) {
            $pdf->AddPage();
            if ($showPages) {
                $pdf->addPageNumber($pagina);
            }

            $pdf->addSociete($this->webDirectory.'bundles/app/img/logo.png');
            $pdf->temporaire("Bunny's Kinder");
            $pdf->addDate(date('d/m/Y'));
            $pdf->addClient($account->getReferenciabancaria());
            $pdf->addAlumnos($alumnos);
            $pdf->addPadres($padres);
            $colsNumbers = array('Item' => 30,
                  'Descripción' => 130,
                   'Precio' => 30,
                  );
            $pdf->addCols($colsNumbers);
            $cols = array('Item' => 'C',
                  'Descripción' => 'C',
                   'Precio' => 'C',
                   );
            $pdf->addLineFormat($cols);
            $y = 70;
            $size = 0;
            $counterItems = 1;

            if ($lineDeuda !== null) {
                $size = $pdf->addLine($y, $lineDeuda);
                $y   += $size + 2;
                ++$counterItems;
            }

            while ($cantidadFacturasDetalles <= $maxPerPage * $pagina && $cantidadFacturasDetalles < count($facturasDetailList)) {
                $facturaDetalle = $facturasDetailList[$cantidadFacturasDetalles];
                if ($facturaDetalle->getAmount() > 0 || $facturaDetalle->getAmount() < 0) {
                    $precioShow = '$0';
                    if ($facturaDetalle->getAmount() > 0) {
                        $precioShow = '$'.$facturaDetalle->getFormatedAmount();
                    } else {
                        $precioShow = '- $'.number_format(-1 * (int) ($facturaDetalle->getAmount()), 0, ',', '.');
                    }
                    $line = array(
                'Item' => $counterItems,
                'Descripción' => $facturaDetalle->getDescription(),
               'Precio' => $precioShow,
            );
                    $paymentQuantity = $paymentQuantity + $facturaDetalle->getAmount();
                    ++$counterItems;
                } else {
                    $line = array(
                'Item' => '',
                'Descripción' => '',
               'Precio' => '',
            );
                }

                $size = $pdf->addLine($y, $line);
                $y   += $size + 2;

                ++$cantidadFacturasDetalles;
            }
            ++$pagina;
            --$cantidadPaginas;
        }

        if ($account->getDiferencia() - $paymentQuantity < 0) {
            $cobro = $this->em->getRepository('AppBundle:Cobro')->retrieveLastFromAccount($account->getId());
            $precion = number_format(-1 * (int) ($account->getDiferencia() - $paymentQuantity), 0, ',', '.');
            $fechaAux = explode('-', $cobro->getFecha());
            $texto = sprintf('Monto pagado (%s-%s-%s)', $fechaAux[2], $fechaAux[1], $fechaAux[0]);
            $line = array(
              'Item' => $counterItems,
              'Descripción' => $texto,
             'Precio' => '- $'.$precion,
      );

            $size = $pdf->addLine($y, $line);
            $y   += $size + 2;
        }
        $pdf->addCadreEurosFrancs('$ '.$account->getFormatedDiferencia());
        $outputOption = 'I';
        if ($location !== null) {
            if (!is_dir($location)) {
                $location = sys_get_temp_dir();
            }
            $outputOption = 'F';
            $location .= DIRECTORY_SEPARATOR;
        } else {
            $location = '';
        }
        $outputName = sprintf('Cuenta-%s-%s.pdf', $account->getReferenciabancaria(), date('m-Y'));
        $pdf->Output($location.$outputName, $outputOption);
        if ($outputOption == 'F') {
            return $location.$outputName;
        }
    }
}
