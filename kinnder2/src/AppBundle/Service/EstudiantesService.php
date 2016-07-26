<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\Form\Form;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater;

use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Cuenta;

class EstudiantesService
{
    protected $em;

    protected $logger;

    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->logger->addDebug('Starting estudiantes service');
    }


    public function createEstudiante(Estudiante $estudiante, FacturasManager $facturasHandler)
    {
        $this->em->persist($estudiante);
        $cuenta = $this->em->getRepository('AppBundle:Cuenta')->findOneBy(array('referenciabancaria' => $estudiante->getReferenciaBancaria()));

        if ($cuenta) {
            $this->logger->addInfo("The student is from an active account");
            foreach ($cuenta->getEstudiantes() as $hermano) {
                $estudiante->addMyBrother($hermano);
                $hermano->addMyBrother($estudiante);
                $this->em->persist($hermano);
            }
            foreach ($cuenta->getProgenitores() as $progenitor) {
                $estudiante->addProgenitore($progenitor);
                $progenitor->addEstudiante($estudiante);
                $this->em->persist($progenitor);
            }
            $estudiante->setCuenta($cuenta);
            $this->em->persist($estudiante);
        } else {
            $this->logger->addInfo("Creating new account for the student");
            $cuenta = new Cuenta();
            $cuenta->setReferenciabancaria($estudiante->getReferenciaBancaria());
            $this->em->persist($cuenta);
            $estudiante->setCuenta($cuenta);
        }
        $this->em->flush();
        $facturasHandler->generateUserAndFinalBill($estudiante);
        $this->regenerateEstudianteNewsletter($estudiante);
        return $estudiante->getId();
    }

    public function regenerateEstudianteNewsletter(Estudiante $estudiante)
    {
      $searchStrings = $this->retrieveEstudianteSearchList($estudiante);
      foreach($estudiante->getMyBrothers() as $brother){
        $searchStrings = array_merge($searchStrings, $this->retrieveEstudianteSearchList($brother));
      }
      
      $groupsLists = array();
      foreach($searchStrings as $searchString){
        $group = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(array('name' => $searchString));
        if(!$group){
          $this->logger->error(sprintf("Group %s SHOULD exits for this user %s.", $searchString, $estudiante->getId()));
        }else{
          $groupsLists[$group->getId()] = $group;
        }
      }
      $addGroups = array();
      $removeGroups = array();
      $initilizated = false;
      foreach($estudiante->getProgenitores() as $parent){
        $newsLetterUser = $parent->getNewsletterUser();
        if(!$initilizated){
          foreach($groupsLists as $newGroups){
            if(!$newsLetterUser->getUserGroups()->contains($newGroups)){
              $addGroups[] = $newGroups;
            }
          }
          foreach($newsLetterUser->getUserGroups() as $userGroup){
            if(!isset($groupsLists[$userGroup->getId()])){
              $removeGroups[] = $userGroup;
            }
          }
          $initilizated = true;
        }
        foreach($addGroups as $newGroups){
          $newsLetterUser->addUserGroup($newGroups);
        }
        foreach($removeGroups as $newGroups){
          $newsLetterUser->removeUserGroup($newGroups);
        }
        $this->em->persist($newsLetterUser);
      }
      $this->em->flush();
    }
    
    private function retrieveEstudianteSearchList(Estudiante $estudiante){
      $searchStrings = array();
      //Generating class and hour string.
      if($estudiante->getEgresado()){
        $searchStrings['EGRESADOS'] = 'EGRESADOS';
      }else{
        $searchStrings[$estudiante->getClase()->getName(). ' ('.$estudiante->getHorario()->getName().')'] = $estudiante->getClase()->getName(). ' ('.$estudiante->getHorario()->getName().')';  
        $searchStrings['PADRES'] = 'PADRES';
        foreach($estudiante->getActividades() as $actividad){
          $searchStrings[] = $actividad->getNombre();
        }
      }
      return $searchStrings;
    }
    
    public function updateEstudiante(Estudiante $estudiante, FacturasManager $facturasHandler)
    {
      $facturasHandler->generateUserAndFinalBill($estudiante);
      $this->regenerateEstudianteNewsletter($estudiante);
    }
    
    public function preparateSearchQueryData(Form $filter, FilterBuilderUpdater $builder)
    {
        $filterBuilder = $this->em->getRepository('AppBundle:Estudiante')
          ->createQueryBuilder('e')
          ->select('e, p')
          ->leftJoin('e.clase', 'c')
          ->leftJoin('e.horario', 'h')
          ->leftJoin('e.progenitores', 'p');
        $filterBuilder->andWhere('e.egresado = false');
        $builder->addFilterConditions($filter, $filterBuilder);
        $queryData = $filterBuilder->getQuery()->getResult();
        $headers = array();
        $entities = array();
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
        return array(
            'headers' => $headers,
            'entities' => $entities,
        );
    }
}
