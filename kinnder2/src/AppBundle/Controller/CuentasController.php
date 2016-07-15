<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\AddFacturaDetalleType;

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



    public function addDetalleFacturaFormAction($facturaId)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:FacturaFinal')->find($facturaId);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cobro entity.');
        }
        $alumnos = array();
        foreach ($entity->getCuenta()->getEstudiantes() as $estudiante) {
            $alumnos[$estudiante->getId()] = $estudiante->getNombre();
        }
        $form = $this->createForm(new AddFacturaDetalleType(), null, array(
          'action' => $this->generateUrl('save_detalle_factura', array('facturaId' => $facturaId)),
          'method' => 'POST',
          'alumnos' => $alumnos,
        ));
        $html = $this->renderView('AppBundle:Cuentas:_detalleFacturaForm.html.twig', array(
                  'facturaId' => $facturaId,
                  'form' => $form->createView(),
          ));
        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'html' => $html,
              ));

        return $response;
    }

    public function saveDetalleFacturaFormAction(Request $request, $facturaId)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:FacturaFinal')->find($facturaId);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Factura entity.');
        }
        $alumnos = array();
        foreach ($entity->getCuenta()->getEstudiantes() as $estudiante) {
            $alumnos[$estudiante->getId()] = $estudiante->getNombre();
        }
        $form = $this->createForm(new AddFacturaDetalleType(), null, array(
          'action' => $this->generateUrl('save_detalle_factura', array('facturaId' => $facturaId)),
          'method' => 'POST',
          'alumnos' => $alumnos,
        ));
        $form->handleRequest($request);
        $result = false;
        $message = 'Ocurrion un error al guardar el detalle.';
        $amount = 0;
        $positive = false;
        $cuentaId = 0;
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();
            $description = $form->get('description')->getData();
            $amount = $form->get('amount')->getData();
            $student = $form->get('alumnos')->getData();
            $month = $entity->getMonth();
            $year = $entity->getYear();

            $estudiante = $em->getRepository('AppBundle:Estudiante')->find($student);
            if (!$estudiante) {
                throw $this->createNotFoundException('Unable to find Estudiante entity.');
            }
            $facturaService = $this->get('facturas');
            $factura = $facturaService->createDetalleFacturaUsuario($estudiante, $month, $year, $description, $amount);
            $result = true;
            $message = 'Factura reseteado al estado original.';
            $html = $this->renderView('AppBundle:Cuentas:_facturaRow.html.twig', array(
                      'factura' => $factura,
              ));
            $cuentaId = $factura->getCuenta()->getId();
            $amount = $factura->getCuenta()->getFormatedDiferencia();
            if ($factura->getCuenta()->getDiferencia() < 0) {
                $positive = true;
            }
        } else {
            $html = $this->renderView('AppBundle:Cuentas:_detalleFacturaForm.html.twig', array(
                      'facturaId' => $facturaId,
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
                'cuentaId' => $cuentaId,
                'facturaId' => $facturaId,
              ));

        return $response;
    }

    public function resetDetalleFacturaFormAction($facturaId)
    {
        $html = $this->renderView('AppBundle:Cuentas:_resetFacturaForm.html.twig', array(
                  'facturaId' => $facturaId,
                  'form' => $this->createResetForm($facturaId)->createView(),
          ));
        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'html' => $html,
              ));

        return $response;
    }

    public function saveResetDetalleFacturaFormAction(Request $request, $facturaId)
    {
        $form = $this->createResetForm($facturaId);
        $form->handleRequest($request);
        $response = new JsonResponse();
        $result = false;
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:FacturaFinal')->find($facturaId);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Factura entity.');
            }
            $facturaService = $this->get('facturas');
            $factura = $facturaService->resetDetalleFacturaFinal($entity);
            $result = true;
            $message = ' Detalle creado correctamente correctamente';
            $html = $this->renderView('AppBundle:Cuentas:_facturaRow.html.twig', array(
                      'factura' => $factura,
              ));
            $cuentaId = $factura->getCuenta()->getId();
            $amount = $factura->getCuenta()->getFormatedDiferencia();
            $positive = false;
            if ($factura->getCuenta()->getDiferencia() < 0) {
                $positive = true;
            }
            $response->setData(array(
                    'result' => $result,
                    'html' => $html,
                    'message' => $message,
                    'amount' => $amount,
                    'positive' => $positive,
                    'cuentaId' => $cuentaId,
                    'facturaId' => $facturaId,
                  ));
        } else {
            $html = $this->renderView('AppBundle:Cuentas:_resetFacturaForm.html.twig', array(
                      'facturaId' => $facturaId,
                      'form' => $this->createResetForm($facturaId)->createView(),
              ));
            $response->setData(array(
                'result' => $result,
                'html' => $html,
                'message' => 'El formulario enviado es invalido.',
              ));
        }

        return $response;
    }
    /**
     * Creates a form to reset a Factura Detail entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createResetForm($facturaId)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('save_reset_factura', array('facturaId' => $facturaId)))
            ->setMethod('PUT')
            ->getForm()
        ;
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
