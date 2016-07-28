<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Cobro;
use AppBundle\Form\Type\CobroType;
use Symfony\Component\HttpFoundation\JsonResponse;

class CobroController extends Controller
{
    public function showCobroPdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Cobro')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cobro entity.');
        }

        $this->get('kinder.pdfs')->exportCobroToPdf($entity);
    }

    public function addCobroFormAction($cuentaId)
    {
        $cobro = new Cobro();
        $form = $this->createCobroForm($cobro, $cuentaId);
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

    private function createCobroForm(Cobro $cobro, $cuentaId)
    {
        return $this->createForm(new CobroType(), $cobro, array(
          'action' => $this->generateUrl('save_cobro', array('cuentaId' => $cuentaId)),
          'method' => 'POST',
        ));
    }

    public function saveCobroFormAction(Request $request, $cuentaId)
    {
        $cobro = new Cobro();
        $form = $this->createCobroForm($cobro, $cuentaId);
        $form->handleRequest($request);
        $cobroService = $this->get('kinder.cobro');
        $responseData = $cobroService->saveCobroForm($form, $cobro, $cuentaId);
        if($responseData['result']){
            $responseData['html'] = $this->renderView('AppBundle:Cuentas:_cobroRow.html.twig', array(
                      'cobro' => $cobro,
              ));
        }else{
            $responseData['html'] = $this->renderView('AppBundle:Cuentas:_cobroForm.html.twig', array(
                    'cuentaId' => $cuentaId,
                    'form' => $form->createView(),
            ));
        }
        $response = new JsonResponse();
        $response->setData($responseData);
        return $response;
    }

    public function disableCobroAction($id)
    {
        $cobroResponse = $this->get('kinder.cuentas')->disableCobro($id);

        if (!$cobroResponse) {
            throw $this->createNotFoundException('Unable to find Cobro entity.');
        }
        $cobro = $cobroResponse['cobro'];
        $html = $this->renderView('AppBundle:Cuentas:_cobroRow.html.twig', array(
                  'cobro' => $cobro,
          ));
        $facturasHtml = $this->retrieveFacturasHtml($cobroResponse['facturas']);

        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'html' => $html,
                'message' => $cobroResponse['message'],
                'amount' => $cobroResponse['amount'],
                'positive' => $cobroResponse['positive'],
                'facturas' => $facturasHtml,
              ));

        return $response;
    }

    public function enableCobroAction($id)
    {
        $cobroResponse = $this->get('kinder.cuentas')->enableCobro($id);

        if (!$cobroResponse) {
            throw $this->createNotFoundException('Unable to find Cobro entity.');
        }
        $html = $this->renderView('AppBundle:Cuentas:_cobroRow.html.twig', array(
                  'cobro' => $cobroResponse['cobro'],
          ));
        $facturasHtml = $this->retrieveFacturasHtml($cobroResponse['facturas']);
        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'html' => $html,
                'message' => $cobroResponse['message'],
                'amount' => $cobroResponse['amount'],
                'positive' => $cobroResponse['positive'],
                'facturas' => $facturasHtml,
              ));

        return $response;
    }

    private function retrieveFacturasHtml($facturas)
    {
        $facturasHtml = array();
        foreach ($facturas as $factura) {
            $facturasHtml[] = array(
            'id' => $factura->getId(),
            'html' => $this->renderView('AppBundle:Cuentas:_facturaRow.html.twig', array(
                      'factura' => $factura,
              )),
          );
        }
        return $facturasHtml;
    }

}
