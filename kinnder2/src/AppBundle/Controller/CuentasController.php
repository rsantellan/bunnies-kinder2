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
        $migrationService->compareCuentas();
        return $this->render('AppBundle:Cuentas:alertas.html.twig', array(
                    'pendingDebts' => $pendingDebts,
            ));    
      
    }

}
