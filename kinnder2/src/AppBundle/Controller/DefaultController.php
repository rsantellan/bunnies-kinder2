<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $obj = new \AppBundle\Entity\GalleryEntity();
        $imagenesMainAlbum = $em->getRepository('MaithCommonAdminBundle:mAlbum')->findOneBy(array('object_id' => $obj->getId(), 'object_class' => $obj->getFullClassName(), 'name' => 'inicio'));
        $mainFiles = array();
        if($imagenesMainAlbum != null){
          $mainFiles = $imagenesMainAlbum->getFiles();
        }
        $imagenesSecondSliderAlbum = $em->getRepository('MaithCommonAdminBundle:mAlbum')->findOneBy(array('object_id' => $obj->getId(), 'object_class' => $obj->getFullClassName(), 'name' => 'filosofia'));
        $secondSliderfiles = array();
        if($imagenesSecondSliderAlbum != null){
          $secondSliderfiles = $imagenesSecondSliderAlbum->getFiles();
        }
        return $this->render('default/index.html.twig', array(
            'mainSlider' => $mainFiles,
            'secondSlider' => $secondSliderfiles,
            'activemenu' => 'homepage'
        ));
    }
    
    public function activitiesAction()
    {
      return $this->render('default/actividades.html.twig', array(
            'activemenu' => 'actividades'
        ));
    }
    
    public function contactAction(Request $request)
    {
      $form = $this->createForm(new \AppBundle\Form\Type\ContactType());
      if ($request->isMethod('POST')) {
          $form->handleRequest($request);
          if ($form->isValid()) {
              $parametersService = $this->get('maith_common.parameters');
              $message = \Swift_Message::newInstance()
              ->setSubject($parametersService->getParameter('contact-email-subject'))
              ->setFrom(array($parametersService->getParameter('contact-email-from') => $parametersService->getParameter('contact-email-from-name')))
              ->setReplyTo($form->get('email')->getData())
              ->setTo(array($parametersService->getParameter('contact-email-to')))
              ->setBody(
                  $this->renderView(
                      'default/contactEmail.html.twig',
                      array(
                          'ip' => $request->getClientIp(),
                          'name' => $form->get('name')->getData(),
                          'lastname' => $form->get('lastname')->getData(),
                          'message' => $form->get('message')->getData(),
                          'phone' => $form->get('phone')->getData(),
                          'email' => $form->get('email')->getData(),
                      )
                  ), 'text/html'
              );

              $this->get('mailer')->send($message);

              $request->getSession()->getFlashBag()->add('success', 'Se a enviado tu consulta con exito. Te contestaremos a la brevedad');

              return $this->redirect($this->generateUrl('contacto'));
          }
      }
      return $this->render('default/contacto.html.twig', array(
            'activemenu' => 'contacto',
            'form' => $form->createView(),
        ));      
    }
    
    public function inscripcionesAction(Request $request)
    {
      $form = $this->createForm(new \AppBundle\Form\Type\InscripcionType());
      if ($request->isMethod('POST')) {
          $form->handleRequest($request);
          if ($form->isValid()) {
              $parametersService = $this->get('maith_common.parameters');
              $message = \Swift_Message::newInstance()
              ->setSubject($parametersService->getParameter('inscripcion-email-subject'))
              ->setFrom(array($parametersService->getParameter('inscripcion-email-from') => $parametersService->getParameter('inscripcion-email-from-name')))
              ->setReplyTo($form->get('email')->getData())
              ->setTo(array($parametersService->getParameter('inscripcion-email-to')))
              ->setBody(
                  $this->renderView(
                      'default/contactEmail.html.twig',
                      array(
                          'ip' => $request->getClientIp(),
                          'name' => $form->get('name')->getData(),
                          'lastname' => $form->get('lastname')->getData(),
                          'message' => $form->get('message')->getData(),
                          'phone' => $form->get('phone')->getData(),
                          'email' => $form->get('email')->getData(),
                      )
                  ), 'text/html'
              );

              $this->get('mailer')->send($message);

              $request->getSession()->getFlashBag()->add('success', 'Se a enviado tu consulta con exito. Te contestaremos a la brevedad');

              return $this->redirect($this->generateUrl('contacto'));
          }
      }
      return $this->render('default/inscripciones.html.twig', array(
            'activemenu' => 'inscripciones',
            'form' => $form->createView(),
      ));   
    }
}
