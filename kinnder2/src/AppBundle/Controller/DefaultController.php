<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pendingDebts = $em->getRepository('AppBundle:Cuenta')->retrieveAllPendingDebts();
        //var_dump($pendingDebts);
        return $this->render('default/index.html.twig');
    }
}
