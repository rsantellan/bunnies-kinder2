<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Cobro;
use AppBundle\Form\Type\CobroType;


class CobroController extends Controller
{
    public function showCobroPdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Cobro')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cobro entity.');
        }

        $pdfData = $this->get('kinder.pdfs')->exportCobroToPdf($entity, null, null, true);
        $response = new Response();
        $response->setContent($pdfData['buffer']);
        $dispositionHeader = $response->headers->makeDisposition(
            'inline',
            $pdfData['name']
        );
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'private, maxage=0, must-revalidate');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        return $response;
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
        return $this->createForm('AppBundle\Form\Type\CobroType', $cobro, array(
          'action' => $this->generateUrl('save_cobro', array('cuentaId' => $cuentaId)),
          'method' => 'POST',
        ));
    }

    public function saveCobroFormAction(Request $request, $cuentaId)
    {
        $cobro = new Cobro();
        $form = $this->createCobroForm($cobro, $cuentaId);
        $form->handleRequest($request);
        $responseData = $this->get('kinder.cobro')->saveCobroForm($form, $cobro, $cuentaId);
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
        $cobroResponse = $this->get('kinder.Cobro')->disableCobro($id);

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
        $cobroResponse = $this->get('kinder.cobro')->enableCobro($id);

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

    public function sendCobroEmailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Cobro')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Cobro entity.');
        }

        $pdfDataLocation = $this->get('kinder.pdfs')->exportCobroToPdf($entity, null, sys_get_temp_dir(), false);
        $title = sprintf('Talon de cobro (%s/%s)', date('n'), date('Y'));
        $parametersService = $this->get('maith_common.parameters');
        $from = [$parametersService->getParameter('contact-email-from') => $parametersService->getParameter('contact-email-from-name')];
        $emails = [];
        foreach ($entity->getCuenta()->getProgenitores() as $progenitor) {
            if($progenitor->getEmail() != ""){
                $emails[] = $progenitor->getEmail();    
            }
        }
        $message = "Hubo un error al enviar el mail, intente nuevamente mas tarde.";
        if(count($emails) > 0){
            $message_account = 'La cuenta está saldada';
            if($entity->getCuenta()->getDiferencia() > 0){
                $message_account = sprintf('Usted debe $%s para dejar la cuenta saldada', $entity->getCuenta()->getDiferencia());
            }else{
              if($cuenta->getDiferencia() < 0)
              {
                $message_account = sprintf('Usted tiene el siguiente saldo a favor $%s', abs($entity->getCuenta()->getDiferencia()));
              }
            }
            $meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
            $htmlBody = $this->renderView('AppBundle:Cuentas:cobroMailProgenitores.html.twig', [
                    'mes' => $meses[date('n')-1],
                    'year' => date('Y'),
                    'referencia' => $entity->getCuenta()->getReferenciabancaria(),
                    'message_account' => $message_account,
                ]);            
            $quantity = $this->get('maith_common.email')->sendWithAttachment($from, $emails, $title, $htmlBody, [$pdfDataLocation]);
            if($quantity > 0){
                $message = "Email enviado con exito";
                $entity->setEnviado(true);
                $em->persist($entity);
                $em->flush();
            }
        }else{
            $message = "No hay ningun padre con email registrado para enviarle el email";
        }
        $response = new JsonResponse();
        $response->setData(array(
                'result' => true,
                'message' => $message,
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
