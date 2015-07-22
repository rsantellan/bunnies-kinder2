<?php

namespace Maith\ContableBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Actividad;
use Maith\NewsletterBundle\Entity\UserGroup;
use AppBundle\DataFixtures\DataFixturesConstants;

/**
 * Description of LoadActividadesFixture
 *
 * @author Rodrigo Santellan
 */
class LoadActividadesFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

  /**
   * @var ContainerInterface
   */
  private $container;

  public function getOrder() {
	return 3;
  }

  public function load(ObjectManager $manager) {
    
	$sql = 'select id, nombre, costo, horario from actividades';
    $username = DataFixturesConstants::DBUSER;
    $password = DataFixturesConstants::DBPASS;
    $database = DataFixturesConstants::DBSCHEMA;
    
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $metadata = $manager->getClassMetaData(get_class(new Actividad()));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    $newsletters = array();
    while($row = $stmt->fetch())
    {
        $nombre = sprintf('%s-%s',$row['nombre'],$row['costo']);
        //$nombre = $row['nombre'];
        $newsLetterGroup = $manager->getRepository('MaithNewsletterBundle:UserGroup')->findOneBy(array('name' => $row['nombre']));
        if(!$newsLetterGroup){
          
          if(isset($newsletters[$nombre])){
            $newsLetterGroup = $newsletters[$nombre];
          }else{
            $newsLetterGroup = new UserGroup();
            $newsLetterGroup->setName($nombre);
            $manager->persist($newsLetterGroup);
            $newsletters[$nombre] = $newsLetterGroup;
          }
        }
        $actividad = new Actividad();
        $actividad->setId($row['id']);
        $actividad->setNombre($nombre);
        $actividad->setCosto($row['costo']);
        $actividad->setHorario($row['horario']);
        $actividad->setNewsLetterGroup($newsLetterGroup);
        $manager->persist($actividad);
        //$metadata = $manager->getClassMetaData(get_class($calendar));
        //$metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
		
    }
    $manager->flush();
    
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

