<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Costos;
use AppBundle\Form\Type\CostosType;

/**
 * Costos controller.
 *
 */
class CostosController extends Controller
{

    /**
     * Lists all Costos entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Costos')->findAll();

        return $this->render('AppBundle:Costos:index.html.twig', array(
            'entities' => $entities,
        ));
    }    

    /**
     * Displays a form to edit an existing Costos entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Costos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Costos entity.');
        }

        $editForm = $this->createEditForm($entity);
        return $this->render('AppBundle:Costos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Costos entity.
    *
    * @param Costos $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Costos $entity)
    {
        $form = $this->createForm(new CostosType(), $entity, array(
            'action' => $this->generateUrl('admin_costos_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Costos entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Costos')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Costos entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_costos_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Costos:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    public function recalculateAction(Request $request){
        $user = $this->container->get('security.context')->getToken()->getUser();
        try{
        $this->get('kinder.crons')->addCronOfType(\AppBundle\Entity\CronObject::RECREATECOSTOS, $user->getUsername());
        $this->get('session')->getFlashBag()->add('notif-success', 'Tarea programada con exito. Correra proximamente enviando un email de confirmación.');
        }catch(\Exception $e){
            $this->get('session')->getFlashBag()->add('notif-error', $e->getMessage());
        }
        return $this->redirect($this->generateUrl('admin_costos'));
    }
}
