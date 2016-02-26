<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\DataFixtures\DataFixturesConstants;
use AppBundle\Entity\Cuenta;
/**
 * Description of LoadCuentasFixture
 *
 * @author Rodrigo Santellan
 */
class LoadCuentasFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

  /**
   * @var ContainerInterface
   */
  private $container;

  public function getOrder() {
	return 8;
  }

  public function load(ObjectManager $manager) {
    
	$sql = 'select id, referenciabancaria, debe, pago, diferencia from cuenta';
    $username = DataFixturesConstants::DBUSER;
    $password = DataFixturesConstants::DBPASS;
    $database = DataFixturesConstants::DBSCHEMA;
    return;
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $metadata = $manager->getClassMetaData(get_class(new Cuenta()));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    while($row = $stmt->fetch())
    {
        // Adding cuenta.
        $cuenta = new Cuenta();
        $cuenta->setId($row['id']);
        //$cuenta->setDebe($row['debe']);
        $cuenta->setDebe(0);
        //$cuenta->setDiferencia($row['diferencia']);
        //$cuenta->setPago($row['pago']);
        $cuenta->setPago(0);
        $cuenta->setReferenciabancaria($row['referenciabancaria']);
        $estudiantes = $manager->getRepository('AppBundle:Estudiante')->findBy(array('referenciaBancaria' => $row['referenciabancaria']));
        $manager->persist($cuenta);
        $brotherParents = true;
        foreach($estudiantes as $estudiante){
          $estudiante->setCuenta($cuenta);
          if($brotherParents)
          {
            foreach($estudiante->getProgenitores() as $progenitor){
              $progenitor->setCuenta($cuenta);
              $manager->persist($progenitor);
            }
          }
          $brotherParents = false;
          $manager->persist($estudiante);
        }
    }
    $manager->flush();
    
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

