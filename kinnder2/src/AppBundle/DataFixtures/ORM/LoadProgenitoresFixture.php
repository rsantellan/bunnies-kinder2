<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\DataFixtures\DataFixturesConstants;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of LoadUserFixture
 *
 * @author Rodrigo Santellan
 */
class LoadProgenitoresFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface{
    
    /**
     * @var ContainerInterface
     */
    private $container;
    
    public function getOrder() {
        return 2;
    }

    public function load(ObjectManager $manager) {
      $sql = 'select id, nombre, direccion, telefono, celular, mail, clave from progenitor';
      $username = DataFixturesConstants::DBUSER;
      $password = DataFixturesConstants::DBPASS;
      $database = DataFixturesConstants::DBSCHEMA;
      $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      
      $userManager = $this->container->get('fos_user.user_manager');
      while($row = $stmt->fetch())
      {
        //var_dump($row);
        //$id = $row['id'];
        $nombre = $row['nombre'];
        $direccion = $row['direccion'];
        $telefono = $row['telefono'];
        $celular = $row['celular'];
        $mail = $row['mail'];
        if($mail){
          $user = $userManager->createUser();
          $user->setUsername($mail);
          $user->setEmail($mail);
          $user->setPlainPassword('bunnyskinder');
          $user->setEnabled(true);
          $user->setSuperAdmin(false);
          $user->setNombre($nombre);
          $user->setDireccion($direccion);
          $user->setTelefono($telefono);
          $user->setCelular($celular);
          $manager->persist($user);
        }
        else
        {
          var_dump('not inserted parent');
          var_dump($row);
        }
      }
      
      $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}


