<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\DataFixtures\DataFixturesConstants;

/**
 * Description of LoadEstudiantesProgenitoresFixture
 *
 * @author Rodrigo Santellan
 */
class LoadEstudiantesProgenitoresFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

  /**
   * @var ContainerInterface
   */
  private $container;

  public function getOrder() {
	return 7;
  }

  public function load(ObjectManager $manager) {
    
	$sql = 'select up.usuario_id, up.progenitor_id, p.mail from usuario_progenitor up left join progenitor p on up.progenitor_id = p.id order by up.progenitor_id';
    $username = DataFixturesConstants::DBUSER;
    $password = DataFixturesConstants::DBPASS;
    $database = DataFixturesConstants::DBSCHEMA;
    return;
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch())
    {
        $progenitor = $manager->getRepository('AppBundle:Progenitor')->findOneBy(array('email' => $row['mail']));
        $estudiante = $manager->getRepository('AppBundle:Estudiante')->find( $row['usuario_id']);
        if($progenitor){
          $progenitor->addEstudiante($estudiante);
          $manager->persist($progenitor);
        }else{
          var_dump($row);
        }
        
    }
    $manager->flush();
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

