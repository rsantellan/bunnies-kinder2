<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CuentasController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pendingDebts = $em->getRepository('AppBundle:Cuenta')->retrieveAllPendingDebts();
        return $this->render('AppBundle:Cuentas:index.html.twig', array(
                    'pendingDebts' => $pendingDebts,
            ));    
      
    }

}
