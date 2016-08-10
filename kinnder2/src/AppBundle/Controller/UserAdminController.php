<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserAdminController extends Controller
{
    public function editAction()
    {
        return $this->render('AppBundle:UserAdmin:edit.html.twig', array(
                // ...
            ));    }

}
