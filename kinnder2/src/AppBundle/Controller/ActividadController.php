<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Actividad;
use AppBundle\Form\Type\ActividadType;

/**
 * Actividad controller.
 *
 */
class ActividadController extends Controller
{

    /**
     * Lists all Actividad entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Actividad')->findAll();

        return $this->render('AppBundle:Actividad:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Actividad entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Actividad();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $newsletterGroup = $this->get('kinder.newslettersync')->updateOrCreateActivityGroup($entity->getNombre(), false);
            $entity->setNewsLetterGroup($newsletterGroup);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_actividades_edit', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Actividad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Actividad entity.
     *
     * @param Actividad $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Actividad $entity)
    {
        $form = $this->createForm(new ActividadType(), $entity, array(
            'method' => 'POST',
        ));
        return $form;
    }

    /**
     * Displays a form to create a new Actividad entity.
     *
     */
    public function newAction()
    {
        $entity = new Actividad();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Actividad:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Actividad entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Actividad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actividad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Actividad:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Actividad entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Actividad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actividad entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Actividad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Actividad entity.
    *
    * @param Actividad $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Actividad $entity)
    {
        $form = $this->createForm(new ActividadType(), $entity, array(
            'action' => $this->generateUrl('admin_actividades_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        return $form;
    }
    /**
     * Edits an existing Actividad entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Actividad')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actividad entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $newsletter = $entity->getNewsLetterGroup();
            $newsletter->setName($entity->getNombre());
            $em->persist($newsletter);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_actividades_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Actividad:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Actividad entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Actividad')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Actividad entity.');
            }
            $em->remove($entity->getNewsLetterGroup());
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_actividades'));
    }

    /**
     * Creates a form to delete a Actividad entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_actividades_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function recalculateAction(Request $request, $id)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        try{
        $this->get('kinder.crons')->addCronOfType(\AppBundle\Entity\CronObject::RECREATEACTIVIDAD, $user->getUsername(), $id);
        $this->get('session')->getFlashBag()->add('notif-success', 'Tarea programada con exito. Correra proximamente enviando un email de confirmación.');
        }catch(\Exception $e){
            $this->get('session')->getFlashBag()->add('notif-error', $e->getMessage());
        }
        return $this->redirect($this->generateUrl('admin_actividades'));
    }
}
