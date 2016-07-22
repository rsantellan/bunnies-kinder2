<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $obj = new \AppBundle\Entity\GalleryEntity();
        $imagenesAlbum = $em->getRepository('MaithCommonAdminBundle:mAlbum')->findOneBy(array('object_id' => $obj->getId(), 'object_class' => $obj->getFullClassName(), 'name' => 'inicio'));
        $files = array();
        if($imagenesAlbum != null){
          $files = $imagenesAlbum->getFiles();
        }
        return $this->render('default/index.html.twig', array(
            'files' => $files,
            'activemenu' => 'homepage'
        ));
    }
}
