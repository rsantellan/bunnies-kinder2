<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CobroType;
use AppBundle\Entity\Cobro;

class CuentasController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pendingDebts = $em->getRepository('AppBundle:Cuenta')->retrieveAllPendingDebts();
        $migrationService = $this->get('migrations');
        //$migrationService->compareCuentas();
        return $this->render('AppBundle:Cuentas:alertas.html.twig', array(
                    'pendingDebts' => $pendingDebts,
            ));
    }

    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $accounts = $em->getRepository('AppBundle:Cuenta')->retrieveAllWithUsersAndParents();

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

        return $this->render('AppBundle:Cuentas:cuentas.html.twig', array(
                    'data' => $data,
                    'activemenu' => 'cuentas',
            ));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Cuenta')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('La cuenta no existe');
        }
        $facturasFinales = $em->getRepository('AppBundle:FacturaFinal')->retrieveFacturasOfAccount($id);
        $cobros = $em->getRepository('AppBundle:Cobro')->retrieveFromAccount($id);

        return $this->render('AppBundle:Cuentas:show.html.twig', array(
                  'cuenta' => $entity,
                  'cobros' => $cobros,
                  'facturas' => $facturasFinales,
                  'activemenu' => 'cuentas',
          ));
    }

    public function showCobroPdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Cobro')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cobro entity.');
        }

        $pdfHandler = $this->get('pdfs');
        $pdfHandler->exportCobroToPdf($entity);
    }

    public function addCobroFormAction($cuentaId)
    {
        $cobro = new Cobro();
        $cobro->setFecha(new \DateTime());
        $form = $this->createForm(new CobroType(), $cobro, array(
          'action' => $this->generateUrl('save_cobro', array('cuentaId' => $cuentaId)),
          'method' => 'POST',
      ));
        $html = $this->renderView('AppBundle:Cuentas:_cobroForm.html.twig', array(
                  'cuentaId' => $cuentaId,
                  'form' => $form->createView(),
          ));
        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'html' => $html,
              ));

        return $response;
    }

    public function saveCobroFormAction(Request $request, $cuentaId)
    {
        $em = $this->getDoctrine()->getManager();

        $cuenta = $em->getRepository('AppBundle:Cuenta')->find($cuentaId);
        if (!$cuenta) {
            throw $this->createNotFoundException('Unable to find Cuenta entity.');
        }
        $cobro = new Cobro();
        $form = $this->createForm(new CobroType(), $cobro, array(
          'action' => $this->generateUrl('save_cobro', array('cuentaId' => $cuentaId)),
          'method' => 'POST',
      ));
        $form->handleRequest($request);
        $result = false;
        $message = 'Ocurrion un error al guardar el cobro.';
        $amount = 0;
        $positive = false;
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $cobro->setCuenta($cuenta);
            $em->persist($cobro);
            $cuenta->addPagoAmount($cobro->getMonto());
            $em->persist($cuenta);
            $em->flush();
            $result = true;
            $message = 'Cobro guardado con exito.';
            if ($cobro->getEnviado()) {
                //send email
            $message .= ' Email enviado correctamente';
            }
            $html = $this->renderView('AppBundle:Cuentas:_cobroRow.html.twig', array(
                      'cobro' => $cobro,
              ));
            $amount = $cuenta->getFormatedDiferencia();
            if ($cuenta->getDiferencia() < 0) {
                $positive = true;
            }
        } else {
            $html = $this->renderView('AppBundle:Cuentas:_cobroForm.html.twig', array(
                    'cuentaId' => $cuentaId,
                    'form' => $form->createView(),
            ));
        }
        $response = new JsonResponse();
        $response->setData(array(
                'result' => $result,
                'html' => $html,
                'message' => $message,
                'amount' => $amount,
                'positive' => $positive,
              ));

        return $response;
    }

    public function disableCobroAction($id)
    {
        $cuentaService = $this->get('cuentas');
        $cobro = $cuentaService->disableCobro($id);

        if (!$cobro) {
            throw $this->createNotFoundException('Unable to find Cobro entity.');
        }
        $html = $this->renderView('AppBundle:Cuentas:_cobroRow.html.twig', array(
                  'cobro' => $cobro,
          ));
        $amount = $cobro->getCuenta()->getFormatedDiferencia();
        $positive = false;
        if ($cobro->getCuenta()->getDiferencia() < 0) {
            $positive = true;
        }
        $message = 'Cobro cancelado con exito';
        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'html' => $html,
                'message' => $message,
                'amount' => $amount,
                'positive' => $positive,
              ));

        return $response;
    }

    public function enableCobroAction($id)
    {
        $cuentaService = $this->get('cuentas');
        $cobro = $cuentaService->enableCobro($id);

        if (!$cobro) {
            throw $this->createNotFoundException('Unable to find Cobro entity.');
        }

        $html = $this->renderView('AppBundle:Cuentas:_cobroRow.html.twig', array(
                  'cobro' => $cobro,
          ));
        $amount = $cobro->getCuenta()->getFormatedDiferencia();
        $positive = false;
        if ($cobro->getCuenta()->getDiferencia() < 0) {
            $positive = true;
        }
        $message = 'Cobro activado con exito';
        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'html' => $html,
                'message' => $message,
                'amount' => $amount,
                'positive' => $positive,
              ));

        return $response;
    }

    public function disableFacturaAction($id)
    {
        $cuentaService = $this->get('cuentas');
        $factura = $cuentaService->disableFactura($id);
        if (!$factura) {
            throw $this->createNotFoundException('Unable to find Factura entity.');
        }
        $html = $this->renderView('AppBundle:Cuentas:_facturaRow.html.twig', array(
                  'factura' => $factura,
          ));
        $amount = $factura->getCuenta()->getFormatedDiferencia();
        $positive = false;
        if ($factura->getCuenta()->getDiferencia() < 0) {
            $positive = true;
        }
        $message = 'Factura cancelada con exito';
        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'html' => $html,
                'message' => $message,
                'amount' => $amount,
                'positive' => $positive,
              ));

        return $response;
    }

    public function enableFacturaAction($id)
    {
        $cuentaService = $this->get('cuentas');
        $factura = $cuentaService->enableFactura($id);
        if (!$factura) {
            throw $this->createNotFoundException('Unable to find Factura entity.');
        }

        $html = $this->renderView('AppBundle:Cuentas:_facturaRow.html.twig', array(
                  'factura' => $factura,
          ));

        $amount = $factura->getCuenta()->getFormatedDiferencia();
        $positive = false;
        if ($factura->getCuenta()->getDiferencia() < 0) {
            $positive = true;
        }
        $message = 'Factura activada con exito';
        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'html' => $html,
                'message' => $message,
                'amount' => $amount,
                'positive' => $positive,
              ));

        return $response;
    }
}
