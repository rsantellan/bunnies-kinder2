<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\Descuento;
use AppBundle\Form\Type\DescuentoType;

/**
 * Descuento controller.
 *
 */
class DescuentoController extends Controller
{

    /**
     * Lists all Descuento entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Descuento')->findAll();

        return $this->render('AppBundle:Descuento:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Displays a form to edit an existing Descuento entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Descuento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Descuento entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('AppBundle:Descuento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Descuento entity.
    *
    * @param Descuento $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Descuento $entity)
    {
        $form = $this->createForm(new DescuentoType(), $entity, array(
            'method' => 'PUT',
        ));
        return $form;
    }
    /**
     * Edits an existing Descuento entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Descuento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Descuento entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_descuento_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Descuento:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        ));
    }
}
