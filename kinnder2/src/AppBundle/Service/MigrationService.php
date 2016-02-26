<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;

use AppBundle\Entity\Actividad;
use AppBundle\Entity\Descuento;
use AppBundle\Entity\Costos;

use Maith\NewsletterBundle\Entity\UserGroup;

/**
 * Description of ActividadMigrationService
 *
 * @author Rodrigo Santellan
 */
class MigrationService {
  protected $em;
  protected $logger;
  protected $oldDb;
  protected $oldDbUser;
  protected $oldDbPassword;
  
  function __construct(EntityManager $em, Logger $logger, $oldDb, $oldDbUser, $oldDbPassword) {
    $this->em = $em;
    $this->logger = $logger;
    $this->logger->addDebug("Actividades migration service");
    $this->oldDb = $oldDb;
    $this->oldDbUser = $oldDbUser;
    $this->oldDbPassword = $oldDbPassword;
  }
  
  private function getConn()
  {
    return new \PDO(sprintf('mysql:host=localhost;dbname=%s', $this->oldDb), $this->oldDbUser, $this->oldDbPassword, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
  }

  private function retrieveOldActivity($id)
  {
    $sql = 'select id, nombre, costo, horario, md_news_letter_group_id from actividades where id = ?';
    $conn = $this->getConn();
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id));
    return $stmt->fetch();
    
  }
  
  public function updateActivity($id)
  {
    $row = $this->retrieveOldActivity($id);
    if(!$row){
      return;
    }
    $name = trim($row['nombre']);
    $activity = $this->em->getRepository('AppBundle:Actividad')->findOneBy(
                array('nombre' => $name)
            );
    if(!$activity)
    {
      $activity = new Actividad();
    }
    $activity->setCosto($row['costo']);
    $activity->setHorario($row['horario']);
    $activity->setNombre($name);
    
    $this->em->persist($activity);
    
    $newsLetterUserGroup = $this->em->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(
                array('name' => $row['nombre'])
            );
    if(!$newsLetterUserGroup){
      $newsLetterUserGroup = new UserGroup();
      $newsLetterUserGroup->setName($name);
      $this->em->persist($newsLetterUserGroup);
      //$this->em->flush();
    }
    $activity->setNewsLetterGroup($newsLetterUserGroup);
    $this->em->persist($activity);
    $this->em->flush();
    return true;
  }
  
  public function removeActivity($id)
  {
    $activity = $this->em->getRepository('AppBundle:Actividad')->find($id);
    if($activity)
    {
      $this->em->remove($activity->getNewsLetterGroup());
      $this->em->remove($activity);
      $this->em->flush();
    }
    return true;
  }

  private function retrieveOldDiscount($id)
  {
    $sql = 'select id, cantidad_de_hermanos, porcentaje from descuentos where id = ?';
    $conn = $this->getConn();
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id));
    return $stmt->fetch();
    
  }

  public function updateDiscount($id)
  {
    $row = $this->retrieveOldDiscount($id);
    if(!$row){
      return;
    }
    $descuento = new Descuento();
    $descuento->setId($row['id']);
    $descuento->setCantidadDeHermanos($row['cantidad_de_hermanos']);
    $descuento->setPorcentaje($row['porcentaje']);
    $this->em->persist($descuento);
    $this->em->flush();
  }

  public function removeDiscount($id)
  {
    $descuento = $this->em->getRepository('AppBundle:Descuento')->find($id);
    if($descuento)
    {
      $this->em->remove($descuento);
      $this->em->flush();
    }
    return true;
  }

  public function updateCostos()
  {
    $costos = $this->em->createQuery('SELECT c FROM AppBundle:Costos c')->setMaxResults(1)->getOneOrNullResult();
    if(!$costos)
    {
      $costos = new Costos();
    }
    $conn = $this->getConn();
    $sqlCostos = 'select matricula, matutino, vespertino, doble_horario from costos';
    $stmtCostos = $conn->prepare($sqlCostos);
    $stmtCostos->execute();
    $rowCostos = $stmtCostos->fetch();
    
    $costos->setMatricula($rowCostos['matricula']);
    $costos->setMatutino($rowCostos['matutino']);
    $costos->setVespertino($rowCostos['vespertino']);
    $costos->setDobleHorario($rowCostos['doble_horario']);
    $this->em->persist($costos);
    $this->em->flush();
    return true;
  } 

}
