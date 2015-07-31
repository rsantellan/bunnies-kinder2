<?php

namespace Maith\ContableBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\Entity\Actividad;
use AppBundle\Entity\Descuento;
use AppBundle\ENtity\Email;
use AppBundle\ENtity\Costos;
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
    
	  $sql = 'select id, nombre, costo, horario, md_news_letter_group_id from actividades';
    $username = DataFixturesConstants::DBUSER;
    $password = DataFixturesConstants::DBPASS;
    $database = DataFixturesConstants::DBSCHEMA;
    
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $stmt = $conn->prepare($sql);
    $stmt->execute();


    $sqlNewsletterGroups = 'select id, name from md_news_letter_group';
    $stmtNewsletterGroups = $conn->prepare($sqlNewsletterGroups);
    $stmtNewsletterGroups->execute();    

    $metadataNewsletterGroup = $manager->getClassMetaData(get_class(new UserGroup()));
    $metadataNewsletterGroup->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    $newsLetterGroups = array();
    while($row = $stmtNewsletterGroups->fetch())
    {
      $newsLetterGroup = new UserGroup();
      $newsLetterGroup->setId($row['id']);
      $newsLetterGroup->setName($row['name']);
      $manager->persist($newsLetterGroup);
      $newsLetterGroups[$row['id']] = $newsLetterGroup;
    }

    $manager->flush();
    sleep(10);
    $metadata = $manager->getClassMetaData(get_class(new Actividad()));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    $newsletters = array();
    while($row = $stmt->fetch())
    {
        /*
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
        */
        $actividad = new Actividad();
        $actividad->setId($row['id']);
        $actividad->setNombre($row['nombre']);
        $actividad->setCosto($row['costo']);
        $actividad->setHorario($row['horario']);
        $actividad->setNewsLetterGroup($newsLetterGroups[$row['md_news_letter_group_id']]);
        $manager->persist($actividad);
    }
    $manager->flush();
    sleep(10);
    $sqlDescuentos = 'select id, cantidad_de_hermanos, porcentaje from descuentos';
    $stmtDescuentos = $conn->prepare($sqlDescuentos);
    $stmtDescuentos->execute();
    $metadataDescuento = $manager->getClassMetaData(get_class(new Descuento()));
    $metadataDescuento->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

    while($row = $stmtDescuentos->fetch())
    {
      $descuento = new Descuento();
      $descuento->setId($row['id']);
      $descuento->setCantidadDeHermanos($row['cantidad_de_hermanos']);
      $descuento->setPorcentaje($row['porcentaje']);
      $manager->persist($descuento);
    }

    $sqlCostos = 'select matricula, matutino, vespertino, doble_horario from costos';
    $stmtCostos = $conn->prepare($sqlCostos);
    $stmtCostos->execute();
    $costos = new Costos();
    $rowCostos = $stmtCostos->fetch();
    
    $costos->setMatricula($rowCostos['matricula']);
    $costos->setMatutino($rowCostos['matutino']);
    $costos->setVespertino($rowCostos['vespertino']);
    $costos->setDobleHorario($rowCostos['doble_horario']);
    $manager->persist($costos);

    $email = new Email();
    $email->setType('newsletter');
    $email->setFromName('Bunnys Kinder');
    $email->setFromMail('info@bunnyskinder.com.uy');
    $email->setId(1);
    $manager->persist($email);
    $manager->flush();
    
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

