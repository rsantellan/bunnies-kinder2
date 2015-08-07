<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Colegio;
use AppBundle\Entity\SociedadMedica;
use AppBundle\Entity\EmergenciaMedica;
use AppBundle\DataFixtures\DataFixturesConstants;

/**
 * Description of LoadEstudiantesFixture
 *
 * @author Rodrigo Santellan
 */
class LoadEstudiantesFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

  /**
   * @var ContainerInterface
   */
  private $container;

  public function getOrder() {
	 return 4;
  }

  public function load(ObjectManager $manager) {
    
	$sql = 'select id, nombre, apellido, fecha_nacimiento, anio_ingreso, sociedad, referencia_bancaria, emergencia_medica, horario, futuro_colegio, descuento, clase, egresado from usuario';
    $username = DataFixturesConstants::DBUSER;
    $password = DataFixturesConstants::DBPASS;
    $database = DataFixturesConstants::DBSCHEMA;
    
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $metadata = $manager->getClassMetaData(get_class(new Estudiante()));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    $colegios = array();
    $sociedadesMedicas = array();
    $emergenciaMedicas = array();
    while($row = $stmt->fetch())
    {
        $id = $row['id'];
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $fechaNacimiento = $row['fecha_nacimiento'];
        $anioIngreso = $row['anio_ingreso'];
        $sociedad = $row['sociedad'];
        $referencia_bancaria = $row['referencia_bancaria'];
        $emergencia_medica = $row['emergencia_medica'];
        $horario = $row['horario'];
        $futuro_colegio = $row['futuro_colegio'];
        $descuento = $row['descuento'];
        $clase = $row['clase'];
        $egresado = $row['egresado'];
        
        $estudiante = new Estudiante();
        $estudiante->setAnioIngreso($anioIngreso);
        $estudiante->setApellido($apellido);
        $estudiante->setDescuento($descuento);
        $estudiante->setEgresado($egresado);
        if($fechaNacimiento){
          $estudiante->setFechaNacimiento(new \DateTime($fechaNacimiento));
        }
        
        $estudiante->setNombre($nombre);
        $estudiante->setReferenciaBancaria($referencia_bancaria);
        $estudiante->setId($id);
        
        if($horario == 'doble_horario'){
          $horario = 'Doble Horario';
        }
        
        $dbHorario = $manager->getRepository('AppBundle:Horario')->findOneBy(array('name' => ucfirst($horario)));
        
        $estudiante->setHorario($dbHorario);
        
        $dbClase = $manager->getRepository('AppBundle:Clase')->findOneBy(array('name' => ucfirst($clase)));
        $estudiante->setClase($dbClase);
        if($futuro_colegio != '')
        {
          $dbColegio = $manager->getRepository('AppBundle:Colegio')->findOneBy(array('name' => $futuro_colegio));
          if(!$dbColegio)
          {
            if(!isset($colegios[$futuro_colegio]))
            {
              $dbColegio = new Colegio();
              $dbColegio->setName($futuro_colegio);
              $manager->persist($dbColegio);
              $colegios[$futuro_colegio] = $dbColegio;  
            }
            else
            {
              $dbColegio = $colegios[$futuro_colegio];
            }
          }
          $estudiante->setFuturoColegio($dbColegio);
        }
        if($sociedad != '')
        {
          $dbSociedad = $manager->getRepository('AppBundle:SociedadMedica')->findOneBy(array('name' => $sociedad));
          if(!$dbSociedad)
          {
            if(!isset($sociedadesMedicas[$sociedad]))
            {
              $dbSociedad = new SociedadMedica();
              $dbSociedad->setName($sociedad);
              $manager->persist($dbSociedad);
              $sociedadesMedicas[$sociedad] = $dbSociedad;  
            }
            else
            {
              $dbSociedad = $sociedadesMedicas[$sociedad];
            }
          }
          $estudiante->setSociedadMedica($dbSociedad);
        }
        
        if($emergencia_medica != '')
        {
          $dbEmergenciaMedica = $manager->getRepository('AppBundle:EmergenciaMedica')->findOneBy(array('name' => $emergencia_medica));
          if(!$dbEmergenciaMedica)
          {
            if(!isset($emergenciaMedicas[$emergencia_medica]))
            {
              $dbEmergenciaMedica = new EmergenciaMedica();
              $dbEmergenciaMedica->setName($emergencia_medica);
              $manager->persist($dbEmergenciaMedica);
              $emergenciaMedicas[$emergencia_medica] = $dbEmergenciaMedica;  
            }
            else
            {
              $dbEmergenciaMedica = $emergenciaMedicas[$emergencia_medica];
            }
          }
          $estudiante->setEmergenciaMedica($dbEmergenciaMedica);
        }
        
        $manager->persist($estudiante);
    }
    $manager->flush();
    
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

