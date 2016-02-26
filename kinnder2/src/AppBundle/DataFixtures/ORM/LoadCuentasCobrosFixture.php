<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\DataFixtures\DataFixturesConstants;
use AppBundle\Entity\Cobro;
/**
 * Description of LoadCuentasFixture
 *
 * @author Rodrigo Santellan
 */
class LoadCuentasCobrosFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

  /**
   * @var ContainerInterface
   */
  private $container;

  public function getOrder() {
	return 9;
  }

  public function load(ObjectManager $manager) {
    
	$sql = 'select id, cuenta_id, fecha, monto from cobro order by cuenta_id';
    $username = DataFixturesConstants::DBUSER;
    $password = DataFixturesConstants::DBPASS;
    $database = DataFixturesConstants::DBSCHEMA;
    return;
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $metadata = $manager->getClassMetaData(get_class(new Cobro()));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    $cuenta = null;
    $cuentaId = null;
    while($row = $stmt->fetch())
    {
        // Adding cobro
        $cobro = new Cobro();
        $cobro->setId($row['id']);
        $fecha = $row['fecha'];
        if($fecha){
          $cobro->setFecha(new \DateTime($fecha));
        }
        $cobro->setMonto($row['monto']);
        if($cuentaId != $row['cuenta_id'])
        {
          $cuenta = $manager->getRepository('AppBundle:Cuenta')->find($row['cuenta_id']);
        }
        $cobro->setCuenta($cuenta);
        $manager->persist($cobro);
    }
    $manager->flush();
    
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

