<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Estudiante;
use AppBundle\Form\EstudianteType;
use AppBundle\Form\EstudianteEditType;
use AppBundle\Filter\EstudianteFilterType;
use AppBundle\Entity\Cuenta;

/**
 * Estudiante controller.
 */
class EstudianteController extends Controller
{
    /**
     * Lists all Estudiante entities.
     */
    public function indexAction(Request $request, $page, $orderBy, $order, $limit)
    {
        $em = $this->getDoctrine()->getManager();
        $filter = $this->get('form.factory')->create(new EstudianteFilterType());

        $entities = $em->getRepository('AppBundle:Estudiante')->getActiveForList($page, $limit, $orderBy, $order);

        return $this->render('AppBundle:Estudiante:index.html.twig', array(
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
        $filter = $this->get('form.factory')->create(new EstudianteFilterType());
        $entities = array();
        if ($request->query->has($filter->getName())) {
            // manually bind values from the request
            $filter->submit($request->query->get($filter->getName()));

            // initialize a query builder
            $filterBuilder = $em->getRepository('AppBundle:Estudiante')
                ->createQueryBuilder('e')
                ->leftJoin('e.clase', 'c');

            // build the query from the given form object
            $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filter, $filterBuilder);

            // now look at the DQL =)
            $filterBuilder->andWhere('e.egresado = false');
            //var_dump($filterBuilder->getDql());
            $entities = $filterBuilder->getQuery()->getResult();
        }

        return $this->render('AppBundle:Estudiante:search.html.twig', array(
            'entities' => $entities,
            'filter' => $filter->createView(),
        ));
    }

    public function checkReferenceAction(Request $request)
    {
        $account = $request->get('account');
        $em = $this->getDoctrine()->getManager();
        $students = $em->getRepository('AppBundle:Estudiante')->findBy(array('referenciaBancaria' => $account));
        $message = 'No hay otro alumno con esa referencia';
        if ($students) {
            if (count($students) == 1) {
                $message = 'El siguiente alumno tiene la misma referencia bancaria.';
            } else {
                $message = 'Los siguientes alumnos tienen la misma referencia bancaria.';
            }
            foreach ($students as $student) {
                $message .= $student->getNombre().' '.$student->getApellido().'.';
            }
        }
        $response = new JsonResponse();
        $response->setData(array(
        'data' => $message,
      ));

        return $response;
    }

    /**
     * Creates a new Estudiante entity.
     */
    public function createAction(Request $request)
    {
        $entity = new Estudiante();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);

            $cuenta = $em->getRepository('AppBundle:Cuenta')->findOneBy(array('referenciabancaria' => $entity->getReferenciaBancaria()));

            if ($cuenta) {
                foreach ($cuenta->getEstudiantes() as $hermano) {
                    $entity->addMyBrother($hermano);
                    $hermano->addMyBrother($entity);
                    $em->persist($hermano);
                }
                foreach ($cuenta->getProgenitores() as $progenitor) {
                    $entity->addProgenitore($progenitor);
                    $progenitor->addEstudiante($entity);
                    $em->persist($progenitor);
                }
                $entity->setCuenta($cuenta);
                $em->persist($entity);
            } else {
                $cuenta = new Cuenta();
                $cuenta->setReferenciabancaria($entity->getReferenciaBancaria());
                $em->persist($cuenta);
                $entity->setCuenta($cuenta);
            }

            $em->flush();
            //die;
            $facturasHandler = $this->get('facturas');
            $facturasHandler->generateUserAndFinalBill($entity);

            return $this->redirect($this->generateUrl('estudiante_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Estudiante:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Estudiante entity.
     *
     * @param Estudiante $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Estudiante $entity)
    {
        $form = $this->createForm(new EstudianteType(), $entity, array(
            'action' => $this->generateUrl('estudiante_create'),
            'method' => 'POST',
        ));

        //$form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Estudiante entity.
     */
    public function newAction()
    {
        $entity = new Estudiante();
        $form = $this->createCreateForm($entity);

        return $this->render('AppBundle:Estudiante:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Estudiante entity.
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Estudiante')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estudiante entity.');
        }

        //$facturasHandler = $this->get('facturas');
        //$facturasHandler->checkAllAccount();

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Estudiante:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function showAccountPdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Estudiante')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estudiante entity.');
        }

        $pdfHandler = $this->get('pdfs');
        $pdfHandler->exportAccountToPdf($entity->getCuenta());
    }

    /**
     * Displays a form to edit an existing Estudiante entity.
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Estudiante')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estudiante entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Estudiante:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Estudiante entity.
     *
     * @param Estudiante $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Estudiante $entity)
    {
        $form = $this->createForm(new EstudianteEditType(), $entity, array(
            'action' => $this->generateUrl('estudiante_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        //$form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Estudiante entity.
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Estudiante')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Estudiante entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $facturasHandler = $this->get('facturas');
            $facturasHandler->generateUserAndFinalBill($entity);

            return $this->redirect($this->generateUrl('estudiante_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Estudiante:edit.html.twig', array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Estudiante entity.
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Estudiante')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Estudiante entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('estudiante'));
    }

    /**
     * Creates a form to delete a Estudiante entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estudiante_delete', array('id' => $id)))
            ->setMethod('DELETE')
            //->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
