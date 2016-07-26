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

    $entity = $em->getRepository('AppBundle:Progenitor')->find($progenitorId);
    $result = false;
    $message = 'Error al desasociar al padre.';
    try{
      if (!$entity) {
        throw $this->createNotFoundException('No se pudo encontrar al padre seleccionado.');
      }

      $estudiantes = $entity->getEstudiantes();
      foreach($estudiantes as $estudiante){
        $entity->getEstudiantes()->removeElement($estudiante);
        $estudiante->removeProgenitore($entity);
        $em->persist($estudiante);
      }
      $em->persist($entity);
      $em->flush();
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
  
  public function addAction(Request $request, $progenitorId, $estudianteId)
  {
    $em = $this->getDoctrine()->getManager();

    $progenitor = $em->getRepository('AppBundle:Progenitor')->find($progenitorId);
    $estudiante = $em->getRepository('AppBundle:Estudiante')->find($estudianteId);
    $result = false;
    $message = 'Error al asociar al padre.';
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
      $em->persist($estudiante);
      $em->persist($progenitor);
      $em->flush();
      $result = true;
      $message = 'Padre asociado correctamente';
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
