<?php

namespace Maith\ContableBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Estudiante;
use AppBundle\DataFixtures\DataFixturesConstants;

/**
 * Description of LoadEstudiantesActividadesFixture
 *
 * @author Rodrigo Santellan
 */
class LoadEstudiantesActividadesFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

  /**
   * @var ContainerInterface
   */
  private $container;

  public function getOrder() {
	return 3;
  }

  public function load(ObjectManager $manager) {
    
	$sql = 'select id, nombre, apellido, fecha_nacimiento, anio_ingreso, sociedad, referencia_bancaria, emergencia_medica, horario, futuro_colegio, descuento, clase, egresado from usuario';
    $username = DataFixturesConstants::DBUSER;
    $password = DataFixturesConstants::DBPASS;
    $database = DataFixturesConstants::DBSCHEMA;
    
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $actividades = $manager->getRepository('MaithContableBundle:Calendario')->findAll();
    $metadata = $manager->getClassMetaData(get_class(new Estudiante()));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    
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
        $estudiante->setClase($clase);
        $estudiante->setDescuento($descuento);
        $estudiante->setEgresado($egresado);
        $estudiante->setEmergenciaMedica($emergencia_medica);
        if($fechaNacimiento){
          $estudiante->setFechaNacimiento(new \DateTime($fechaNacimiento));
        }
        
        $estudiante->setFuturoColegio($futuro_colegio);
        $estudiante->setHorario($horario);
        $estudiante->setNombre($nombre);
        $estudiante->setReferenciaBancaria($referencia_bancaria);
        $estudiante->setSociedad($sociedad);
        $estudiante->setId($id);
        $manager->persist($estudiante);
    }
    $manager->flush();
    
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

