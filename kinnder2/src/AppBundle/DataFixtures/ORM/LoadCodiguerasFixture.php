<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Actividad;
use AppBundle\Entity\Descuento;
use AppBundle\ENtity\Email;
use AppBundle\ENtity\Costos;
use AppBundle\ENtity\Horario;
use AppBundle\ENtity\Clase;
use Maith\NewsletterBundle\Entity\UserGroup;
use AppBundle\DataFixtures\DataFixturesConstants;

/**
 * Description of LoadCodiguerasFixture
 *
 * @author Rodrigo Santellan
 */
class LoadCodiguerasFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

  /**
   * @var ContainerInterface
   */
  private $container;

  public function getOrder() {
	return 3;
  }

  public function load(ObjectManager $manager) {
    
    /**
     * 
     * Email
     * 
     **/ 
    $email = new Email();
    $email->setType('newsletter');
    $email->setFromName('Bunnys Kinder');
    $email->setFromMail('info@bunnyskinder.com.uy');
    $email->setId(1);
    $manager->persist($email);
    
    /**
     * 
     * Horarios
     * 
     */
    
    $matutino = new Horario();
    $matutino->setName('Matutino');
    $matutino->setDbname('matutino');
    $manager->persist($matutino);
    $vespertino = new Horario();
    $vespertino->setName('Vespertino');
    $vespertino->setDbname('vespertino');
    $manager->persist($vespertino);
    $dobleHorario = new Horario();
    $dobleHorario->setName('Doble Horario');
    $dobleHorario->setDbname('doble_horario');
    $manager->persist($dobleHorario);
    
    /***
     * 
     * Clases
     * 
     ***/
    
    $verde = new Clase();
    $verde->setName('Verde');
    $manager->persist($verde);
    
    $amarillo = new Clase();
    $amarillo->setName('Amarillo');
    $manager->persist($amarillo);
    
    $rojo = new Clase();
    $rojo->setName('Rojo');
    $manager->persist($rojo);
    
    
    $manager->flush();
    
    return;
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

