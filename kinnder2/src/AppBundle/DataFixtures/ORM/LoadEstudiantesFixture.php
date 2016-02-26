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
    return;
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

