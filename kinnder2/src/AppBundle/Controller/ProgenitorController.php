<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Progenitor;
use AppBundle\Form\ProgenitorType;
use AppBundle\Filter\ProgenitorFilterType;

/**
 * Progenitor controller.
 */
class ProgenitorController extends Controller
{
    /**
     * Lists all Progenitor entities.
     */
    public function indexAction(Request $request, $page, $orderBy, $order, $limit)
    {
        $em = $this->getDoctrine()->getManager();
        $filter = $this->get('form.factory')->create(new ProgenitorFilterType());

        $entities = $em->getRepository('AppBundle:Progenitor')->getActiveForList($page, $limit, $orderBy, $order);

        return $this->render('AppBundle:Progenitor:index.html.twig', array(
            'entities' => $entities,
            'page' => $page,
            'orderBy' => $orderBy,
            'order' => $order,
            'limit' => $limit,
            'filter' => $filter->createView(),
        ));
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $filter = $this->get('form.factory')->create(new ProgenitorFilterType());
        $entities = array();
        if ($request->query->has($filter->getName())) {
            // manually bind values from the request
            $filter->submit($request->query->get($filter->getName()));

            // initialize a query builder
            $filterBuilder = $em->getRepository('AppBundle:Progenitor')
                ->createQueryBuilder('p');

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filter, $filterBuilder);

            // now look at the DQL =)
            //$filterBuilder->andWhere('e.egresado = false');
            //var_dump($filterBuilder->getDql());
            $entities = $filterBuilder->getQuery()->getResult();
        }

        return $this->render('AppBundle:Progenitor:search.html.twig', array(
            'entities' => $entities,
            'filter' => $filter->createView(),
        ));
    }

    /**
     * Creates a new Progenitor entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Progenitor();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_progenitor_edit', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Progenitor:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Progenitor entity.
     *
     * @param Progenitor $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Progenitor $entity)
    {
        $form = $this->createForm(new ProgenitorType(), $entity, array(
            'action' => $this->generateUrl('admin_progenitor_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Progenitor entity.
     */
    public function newAction()
    {
        $entity = new Progenitor();
        $form = $this->createCreateForm($entity);

        return $this->render('AppBundle:Progenitor:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Progenitor entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Progenitor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Progenitor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Progenitor:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Progenitor entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Progenitor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Progenitor entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Progenitor:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Progenitor entity.
     *
     * @param Progenitor $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Progenitor $entity)
    {
        $form = $this->createForm(new ProgenitorType(), $entity, array(
            'action' => $this->generateUrl('admin_progenitor_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Progenitor entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Progenitor')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Progenitor entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_progenitor_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Progenitor:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Progenitor entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Progenitor')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Progenitor entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_progenitor'));
    }

    /**
     * Creates a form to delete a Progenitor entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_progenitor_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
