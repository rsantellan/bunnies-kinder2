<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Filter\EstudianteFilterType;
use AppBundle\Filter\EstudianteExportFilterType;

class EstudianteSearchController extends Controller
{
    /**
     * Lists all Estudiante entities.
     */
    public function indexAction(Request $request, $page, $orderBy, $order, $limit)
    {
        $data = $this->getDataForList($page, $limit, $orderBy, $order, false, false);
        $links = $this->returnIndexLinks($page, $orderBy, $order);

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

    private function returnIndexLinks($page, $orderBy, $order)
    {
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
        return $links;
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

        $links = $this->returnFuturosLinks($page, $orderBy, $order);
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

    private function returnFuturosLinks($page, $orderBy, $order)
    {
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
        return $links;
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

        $links = $this->returnEgresadosLinks($page, $orderBy, $order);
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

    private function returnEgresadosLinks($page, $orderBy, $order)
    {
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
        return $links;
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
            $data = $this->get('kinder.estudiantes')->preparateSearchQueryData($filter, $this->get('lexik_form_filter.query_builder_updater'));
            $entities = $data['entities'];
            if ((boolean) $filterData['exportar']) {
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
            $counter = 0;
            foreach ($row as $field) {
                $letter = \PHPExcel_Cell::stringFromColumnIndex($counter);
                $objPHPExcel->getActiveSheet()
                    ->setCellValue($letter.$index, $field);
                $objPHPExcel->getActiveSheet()->getColumnDimension($letter)->setAutoSize(true);
                ++$counter;
            }
            ++$index;
        }

        $fileName = 'alumnos-'.date('d-m-Y').'.xls';
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
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
        return $response;
    }
}
