<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestingController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:Testing:index.html.twig', array(
                // ...
            ));
    }
}
