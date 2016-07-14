<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Estudiante;
use AppBundle\Form\EstudianteType;
use AppBundle\Form\EstudianteEditType;
use AppBundle\Filter\EstudianteFilterType;
use AppBundle\Filter\EstudianteExportFilterType;
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
        $data = $this->getDataForList($page, $limit, $orderBy, $order, false, false);

        $links = array(
          'nombre' => $this->generateUrl('estudiante', array('page' => 0, 'orderBy' => 'nombre', 'order' => 'asc')),
          'apellido' => $this->generateUrl('estudiante', array('page' => 0, 'orderBy' => 'apellido', 'order' => 'asc')),
          'fechaNacimiento' => $this->generateUrl('estudiante', array('page' => 0, 'orderBy' => 'fechaNacimiento', 'order' => 'asc')),
          'referenciaBancaria' => $this->generateUrl('estudiante', array('page' => 0, 'orderBy' => 'referenciaBancaria', 'order' => 'asc')),
          'clase' => $this->generateUrl('estudiante', array('page' => 0, 'orderBy' => 'clase', 'order' => 'asc')),
          'filter' => $this->generateUrl('estudiante_search'),
          'base' => $this->generateUrl('estudiante'),
          'nextPage' => $this->generateUrl('estudiante', array('page' => $page + 1, 'orderBy' => $orderBy, 'order' => $order)),
          'prevPage' => $this->generateUrl('estudiante', array('page' => $page - 1, 'orderBy' => $orderBy, 'order' => $order)),
        );
        switch ($orderBy) {
          case 'nombre':
            $links['nombre'] = $this->generateUrl('estudiante', array('page' => 0, 'orderBy' => 'nombre', 'order' => 'desc'));
            break;
          case 'apellido':
            $links['apellido'] = $this->generateUrl('estudiante', array('page' => 0, 'orderBy' => 'apellido', 'order' => 'desc'));
            break;
          case 'fechaNacimiento':
            $links['fechaNacimiento'] = $this->generateUrl('estudiante', array('page' => 0, 'orderBy' => 'fechaNacimiento', 'order' => 'desc'));
            break;
          case 'referenciaBancaria':
            $links['referenciaBancaria'] = $this->generateUrl('estudiante', array('page' => 0, 'orderBy' => 'referenciaBancaria', 'order' => 'desc'));
            break;
          case 'clase':
            $links['clase'] = $this->generateUrl('estudiante', array('page' => 1, 'orderBy' => 'clase', 'order' => 'desc'));
            break;
          default:
            break;
        }
        if (count($data['entities']) < $limit) {
            unset($links['nextPage']);
        }
        if ($page == 0) {
            unset($links['prevPage']);
        }
        $data['links'] = $links;
        $data['title'] = $this->get('translator')->trans('students_title');

        return $this->render('AppBundle:Estudiante:index.html.twig', $data);
    }

    public function searchAction(Request $request)
    {
        $data = $this->doSearch($request, false, false);
        $data['links'] = array(
          'filter' => $this->generateUrl('estudiante_search'),
          'base' => $this->generateUrl('estudiante'),
        );
        $data['title'] = $this->get('translator')->trans('students_title_search');

        return $this->render('AppBundle:Estudiante:search.html.twig', $data);
    }

    /**
     * Lists all Estudiante entities.
     */
    public function futurosAction(Request $request, $page, $orderBy, $order, $limit)
    {
        $data = $this->getDataForList($page, $limit, $orderBy, $order, false, true);

        $links = array(
          'nombre' => $this->generateUrl('estudiante_futuros', array('page' => 0, 'orderBy' => 'nombre', 'order' => 'asc')),
          'apellido' => $this->generateUrl('estudiante_futuros', array('page' => 0, 'orderBy' => 'apellido', 'order' => 'asc')),
          'fechaNacimiento' => $this->generateUrl('estudiante_futuros', array('page' => 0, 'orderBy' => 'fechaNacimiento', 'order' => 'asc')),
          'referenciaBancaria' => $this->generateUrl('estudiante_futuros', array('page' => 0, 'orderBy' => 'referenciaBancaria', 'order' => 'asc')),
          'clase' => $this->generateUrl('estudiante_futuros', array('page' => 0, 'orderBy' => 'clase', 'order' => 'asc')),
          'filter' => $this->generateUrl('estudiante_futuros_search'),
          'base' => $this->generateUrl('estudiante_futuros'),
          'nextPage' => $this->generateUrl('estudiante_futuros', array('page' => $page + 1, 'orderBy' => $orderBy, 'order' => $order)),
          'prevPage' => $this->generateUrl('estudiante_futuros', array('page' => $page - 1, 'orderBy' => $orderBy, 'order' => $order)),
        );
        switch ($orderBy) {
          case 'nombre':
            $links['nombre'] = $this->generateUrl('estudiante_futuros', array('page' => 0, 'orderBy' => 'nombre', 'order' => 'desc'));
            break;
          case 'apellido':
            $links['apellido'] = $this->generateUrl('estudiante_futuros', array('page' => 0, 'orderBy' => 'apellido', 'order' => 'desc'));
            break;
          case 'fechaNacimiento':
            $links['fechaNacimiento'] = $this->generateUrl('estudiante_futuros', array('page' => 0, 'orderBy' => 'fechaNacimiento', 'order' => 'desc'));
            break;
          case 'referenciaBancaria':
            $links['referenciaBancaria'] = $this->generateUrl('estudiante_futuros', array('page' => 0, 'orderBy' => 'referenciaBancaria', 'order' => 'desc'));
            break;
          case 'clase':
            $links['clase'] = $this->generateUrl('estudiante_futuros', array('page' => 1, 'orderBy' => 'clase', 'order' => 'desc'));
            break;
          default:
            break;
        }
        if (count($data['entities']) < $limit) {
            unset($links['nextPage']);
        }
        if ($page == 0) {
            unset($links['prevPage']);
        }
        $data['links'] = $links;
        $data['title'] = $this->get('translator')->trans('students_egresados_title');

        return $this->render('AppBundle:Estudiante:index.html.twig', $data);
    }

    public function futurosSearchAction(Request $request)
    {
        $data = $this->doSearch($request, false, true);
        $data['title'] = $this->get('translator')->trans('students_egresados_title_search');
        $data['links'] = array(
        'filter' => $this->generateUrl('estudiante_futuros_search'),
        'base' => $this->generateUrl('estudiante_futuros'),
      );

        return $this->render('AppBundle:Estudiante:search.html.twig', $data);
    }

    /**
     * Lists all Estudiante entities.
     */
    public function egresadosAction(Request $request, $page, $orderBy, $order, $limit)
    {
        $data = $this->getDataForList($page, $limit, $orderBy, $order, true, false);

        $links = array(
          'nombre' => $this->generateUrl('estudiante_egresados', array('page' => 0, 'orderBy' => 'nombre', 'order' => 'asc')),
          'apellido' => $this->generateUrl('estudiante_egresados', array('page' => 0, 'orderBy' => 'apellido', 'order' => 'asc')),
          'fechaNacimiento' => $this->generateUrl('estudiante_egresados', array('page' => 0, 'orderBy' => 'fechaNacimiento', 'order' => 'asc')),
          'referenciaBancaria' => $this->generateUrl('estudiante_egresados', array('page' => 0, 'orderBy' => 'referenciaBancaria', 'order' => 'asc')),
          'clase' => $this->generateUrl('estudiante_egresados', array('page' => 0, 'orderBy' => 'clase', 'order' => 'asc')),
          'filter' => $this->generateUrl('estudiante_egresados_search'),
          'base' => $this->generateUrl('estudiante_egresados'),
          'nextPage' => $this->generateUrl('estudiante_egresados', array('page' => $page + 1, 'orderBy' => $orderBy, 'order' => $order)),
          'prevPage' => $this->generateUrl('estudiante_egresados', array('page' => $page - 1, 'orderBy' => $orderBy, 'order' => $order)),
        );
        switch ($orderBy) {
          case 'nombre':
            $links['nombre'] = $this->generateUrl('estudiante_egresados', array('page' => 0, 'orderBy' => 'nombre', 'order' => 'desc'));
            break;
          case 'apellido':
            $links['apellido'] = $this->generateUrl('estudiante_egresados', array('page' => 0, 'orderBy' => 'apellido', 'order' => 'desc'));
            break;
          case 'fechaNacimiento':
            $links['fechaNacimiento'] = $this->generateUrl('estudiante_egresados', array('page' => 0, 'orderBy' => 'fechaNacimiento', 'order' => 'desc'));
            break;
          case 'referenciaBancaria':
            $links['referenciaBancaria'] = $this->generateUrl('estudiante_egresados', array('page' => 0, 'orderBy' => 'referenciaBancaria', 'order' => 'desc'));
            break;
          case 'clase':
            $links['clase'] = $this->generateUrl('estudiante_egresados', array('page' => 1, 'orderBy' => 'clase', 'order' => 'desc'));
            break;
          default:
            break;
        }
        if (count($data['entities']) < $limit) {
            unset($links['nextPage']);
        }
        if ($page == 0) {
            unset($links['prevPage']);
        }
        $data['links'] = $links;
        $data['title'] = $this->get('translator')->trans('students_future_title');

        return $this->render('AppBundle:Estudiante:index.html.twig', $data);
    }

    public function egresadosSearchAction(Request $request)
    {
        $data = $this->doSearch($request, true, false);
        $data['title'] = $this->get('translator')->trans('students_future_title_search');
        $data['links'] = array(
        'filter' => $this->generateUrl('estudiante_egresados_search'),
        'base' => $this->generateUrl('estudiante_egresados'),
      );

        return $this->render('AppBundle:Estudiante:search.html.twig', $data);
    }

    private function getDataForList($page = 0, $limit = 10, $orderBy = 'apellido', $order = 'ASC', $egresado = false, $future = false)
    {
        $em = $this->getDoctrine()->getManager();
        $filter = $this->get('form.factory')->create(new EstudianteFilterType());

        $entities = $em->getRepository('AppBundle:Estudiante')->getDataForList($page, $limit, $orderBy, $order, $egresado, $future);

        return array(
          'entities' => $entities,
          'page' => $page,
          'orderBy' => $orderBy,
          'order' => $order,
          'limit' => $limit,
          'filter' => $filter->createView(),
      );
    }

    private function doSearch(Request $request, $egresado = false, $future = false)
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
          if (!$egresado) {
              $filterBuilder->andWhere('e.egresado = false');
              if (!$future) {
                  $filterBuilder->andWhere('e.anioIngreso <= '.date('Y'));
              } else {
                  $filterBuilder->andWhere('e.anioIngreso > '.date('Y'));
              }
          } else {
              $filterBuilder->andWhere('e.egresado = true');
          }

          //var_dump($filterBuilder->getDql());
          $entities = $filterBuilder->getQuery()->getResult();
        }

        return array(
          'entities' => $entities,
          'filter' => $filter->createView(),
      );
    }

    public function exportDatosShowAction(Request $request)
    {
        $filter = $this->get('form.factory')->create(new EstudianteExportFilterType());
        $entities = array();
        $filterMetadata = array();
        if ($request->query->has($filter->getName())) {
            $filterData = $request->query->get($filter->getName());
            $exportar = (boolean) $filterData['exportar'];
            $useEstudianteRow = true;
            if (isset($filterData['estudiantes'])) {
                $estudiantesRow = array_flip($filterData['estudiantes']);
                $useEstudianteRow = false;
            } else {
                $estudiantesRow = array();
            }
            $usePadresRow = true;
            if (isset($filterData['padres'])) {
                $padresRow = array_flip($filterData['padres']);
                $usePadresRow = false;
            } else {
                $padresRow = array();
            }

            $filterMetadata = array(
              'usePadresRow' => $usePadresRow,
              'useEstudianteRow' => $useEstudianteRow,
              'estudiantesRow' => $estudiantesRow,
              'padresRow' => $padresRow,
          );

            $filter->submit($request->query->get($filter->getName()));
            $em = $this->getDoctrine()->getManager();
            $filterBuilder = $em->getRepository('AppBundle:Estudiante')
              ->createQueryBuilder('e')
              ->select('e, p')
              ->leftJoin('e.clase', 'c')
              ->leftJoin('e.horario', 'h')
              ->leftJoin('e.progenitores', 'p');
            $filterBuilder->andWhere('e.egresado = false');
          // build the query from the given form object
          $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filter, $filterBuilder);
            $queryData = $filterBuilder->getQuery()->getResult();
            $headers = array();
            foreach ($queryData as $data) {
                $auxData = array();
                $auxData['referenciaBancaria'] = $data->getCuenta()->getReferenciabancaria();
                $auxData['nombre'] = $data->getNombre();
                $auxData['apellido'] = $data->getApellido();
                $auxData['fechaNacimiento'] = $data->getFechaNacimiento();
                $auxData['anioIngreso'] = $data->getAnioIngreso();
                $auxData['sociedadMedica'] = '';
                if ($data->getSociedadMedica()) {
                    $auxData['sociedadMedica'] = $data->getSociedadMedica()->getName();
                }
                $auxData['emergenciaMedica'] = '';
                if ($data->getEmergenciaMedica()) {
                    $auxData['emergenciaMedica'] = $data->getEmergenciaMedica()->getName();
                }
                $auxData['horario'] = '';
                if ($data->getHorario()) {
                    $auxData['horario'] = $data->getHorario()->getName();
                }
                $auxData['futuroColegio'] = '';
                if ($data->getFuturoColegio()) {
                    $auxData['futuroColegio'] = $data->getFuturoColegio()->getName();
                }
                $auxData['clase'] = '';
                if ($data->getClase()) {
                    $auxData['clase'] = $data->getClase()->getName();
                }
                $auxData['progenitor'] = '';
                $auxData['email'] = '';
                $auxData['direccion'] = '';
                $auxData['telefono'] = '';
                $auxData['celular'] = '';

                foreach ($data->getProgenitores() as $progenitor) {
                    if ($auxData['email'] != '') {
                        $auxData['email'] = $auxData['email'].', '.$progenitor->getEmail();
                    } else {
                        $auxData['email'] = $progenitor->getEmail();
                    }
                    if ($auxData['progenitor'] != '' && $progenitor->getNombre() !== '') {
                        $auxData['progenitor'] = $auxData['progenitor'].', '.$progenitor->getNombre();
                    } else {
                        $auxData['progenitor'] = $auxData['progenitor'].$progenitor->getNombre();
                    }
                    if ($auxData['direccion'] != '' && $progenitor->getDireccion() !== '') {
                        $auxData['direccion'] = $auxData['direccion'].', '.$progenitor->getDireccion();
                    } else {
                        $auxData['direccion'] = $auxData['direccion'].$progenitor->getDireccion();
                    }
                    if ($auxData['telefono'] != '' && $progenitor->getTelefono() !== '') {
                        $auxData['telefono'] = $auxData['telefono'].', '.$progenitor->getTelefono();
                    } else {
                        $auxData['telefono'] = $auxData['telefono'].$progenitor->getTelefono();
                    }
                    if ($auxData['celular'] != '' && $progenitor->getCelular() !== '') {
                        $auxData['celular'] = $auxData['celular'].', '.$progenitor->getCelular();
                    } else {
                        $auxData['celular'] = $auxData['celular'].$progenitor->getCelular();
                    }
                }
                $headers = array_keys($auxData);
                $entities[] = $auxData;
            }
            $export = (boolean) $filterData['exportar'];
            if ($export) {
                return $this->exportExcel($headers, $entities);
            }
        }

        $data = array(
        'entities' => $entities,
        'filter' => $filter->createView(),
        'filterMetadata' => $filterMetadata,
      );

        return $this->render('AppBundle:Estudiante:exportDatos.html.twig', $data);
    }

    private function exportExcel($headers, $data)
    {
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()
                ->setCreator("Bunny's Kinder")
                ->setTitle('Listado de alumnos y padres')
                ->setSubject('Listado de alumnos y padres');

        $styleArray = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => \PHPExcel_Style_Border::BORDER_THIN,
                  ),
              ),
          );
        $objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0);
        $index = 1;
        $counter = 0;
        foreach ($headers as $header) {
            $letter = \PHPExcel_Cell::stringFromColumnIndex($counter);
            $objPHPExcel->getActiveSheet()
                ->setCellValue($letter.$index, $header);
            $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
            ++$counter;
        }
        ++$index;
        foreach ($data as $row) {
            //var_dump($row);
            $counter = 0;
            foreach ($row as $field) {
                //var_dump($field);
                $letter = \PHPExcel_Cell::stringFromColumnIndex($counter);
                $objPHPExcel->getActiveSheet()
                    ->setCellValue($letter.$index, $field);
                $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
                ++$counter;
            }
            ++$index;
        }

        $fileName = 'alumnos-'.date('d-m-Y').'.xls';
        /*
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');
        header('Cache-Control: max-age=0');
        */
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        //$objWriter->save('php://output');
        $response = new \Symfony\Component\HttpFoundation\StreamedResponse(
            function() use ($objWriter){
                $objWriter->save('php://output');
            }
        );
        $dispositionHeader = $response->headers->makeDisposition(
            'attachment',
            $fileName
        );
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);
        //$response->sendHeaders();
        //var_dump($response->headers);
        return $response;
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
