<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GalleryController extends Controller
{
    public function listAction()
    {
        $obj = new \AppBundle\Entity\GalleryEntity();
        return $this->render('AppBundle:Gallery:list.html.twig', array(
                'entity' => $obj,
        ));    
    }

}
