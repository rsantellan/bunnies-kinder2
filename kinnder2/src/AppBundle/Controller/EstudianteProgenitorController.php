<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class EstudianteProgenitorController extends Controller
{
  
  public function deleteAction(Request $request, $progenitorId)
  {
    $em = $this->getDoctrine()->getManager();

    $progenitor = $em->getRepository('AppBundle:Progenitor')->find($progenitorId);
    $result = false;
    $message = 'Error al desasociar al padre.';
    try{
      if (!$progenitor) {
        throw $this->createNotFoundException('No se pudo encontrar al padre seleccionado.');
      }

      $estudiantes = $progenitor->getEstudiantes();
      foreach($estudiantes as $estudiante){
        $progenitor->getEstudiantes()->removeElement($estudiante);
        $estudiante->removeProgenitore($progenitor);
        $em->persist($estudiante);
      }
      $progenitor->removeCuenta();
      $em->persist($progenitor);
      $em->flush();
      $this->get('kinder.newslettersync')->regenerateProgenitorNewsletter($progenitor);
      $result = true;
      $message = 'Padre desasociado correctamente';
    } catch (\Exception $ex) {
      $this->get('logger')->error($ex);
      
    }
    $response = new JsonResponse();
    $response->setData(array(
            'result' => $result,
            'message' => $message,
            'id' => $progenitorId,
          ));
    return $response;
  }
  
  public function addAction(Request $request, $estudianteId)
  {
    $em = $this->getDoctrine()->getManager();
    $progenitorId = $request->get('progenitorId');
    $progenitor = $em->getRepository('AppBundle:Progenitor')->find($progenitorId);
    $estudiante = $em->getRepository('AppBundle:Estudiante')->find($estudianteId);
    $result = false;
    $message = 'Error al asociar al padre.';
    $html = '';
    try{
      if (!$progenitor) {
        throw $this->createNotFoundException('No se pudo encontrar al padre seleccionado.');
      }
      if (!$estudiante) {
        throw $this->createNotFoundException('No se pudo encontrar al estudiante seleccionado.');
      }
      $referenciaBancaria = $estudiante->getCuenta()->getReferenciabancaria(); 
      foreach($progenitor->getEstudiantes() as $oldEstudent){
        if($oldEstudent->getCuenta()->getReferenciabancaria() != $referenciaBancaria){
          throw new \Exception("Este padre ya tiene un hijo asignado con otra referencia bancaria");
        }
      }
      $progenitor->addEstudiante($estudiante);
      $estudiante->addProgenitore($progenitor);
      $progenitor->setCuenta($estudiante->getCuenta());
      $em->persist($estudiante);
      $em->persist($progenitor);
      $em->flush();
      $this->get('kinder.newslettersync')->regenerateProgenitorNewsletter($progenitor);
      $result = true;
      $message = 'Padre asociado correctamente';
      $html = $this->renderView('AppBundle:Estudiante:_progenitorList.html.twig', array('progenitor' => $progenitor));
    } catch (\Doctrine\DBAL\DBALException $ex) {
      $this->get('logger')->error($ex);
      $message = 'El padre elegido ya se encuentra asociado al alumno';
    } catch (\Exception $ex) {
      $this->get('logger')->error($ex);
      $message = $ex->getMessage();
    }
    $response = new JsonResponse();
    $response->setData(array(
            'result' => $result,
            'message' => $message,
            'id' => $progenitorId,
            'html' => $html,
          ));
    return $response;
  }
  
  public function searchAction(Request $request){
    
    $term = '%'.$request->get('term') . '%';
    
    $dql = 'select p.id, p.nombre, p.email from AppBundle:Progenitor p where p.nombre like :term or p.email like :term';
    $em = $this->getDoctrine()->getManager();
    $results = $em->createQuery($dql)->setParameters(array('term' => $term))->getArrayResult();
    $returnData = array();
    foreach($results as $result){
      $returnData[] = array('id' => $result['id'], 'value' => $result['nombre']. ' - '.$result['email']);
    }
    $response = new JsonResponse();
    $response->setData($returnData);
    return $response;
  }
}
