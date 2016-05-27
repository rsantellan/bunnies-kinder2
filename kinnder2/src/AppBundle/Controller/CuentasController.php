<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    public function showAction($id){
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
      die($id);
    }
}
