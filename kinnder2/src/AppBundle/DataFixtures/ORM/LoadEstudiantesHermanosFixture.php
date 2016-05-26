<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\DataFixtures\DataFixturesConstants;

/**
 * Description of LoadEstudiantesHermanosFixture.
 *
 * @author Rodrigo Santellan
 */
class LoadEstudiantesHermanosFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
   * @var ContainerInterface
   */
  private $container;

    public function getOrder()
    {
        return 6;
    }

    public function load(ObjectManager $manager)
    {
        $sql = 'select usuario_from, usuario_to from hermanos';
        $username = DataFixturesConstants::DBUSER;
        $password = DataFixturesConstants::DBPASS;
        $database = DataFixturesConstants::DBSCHEMA;

        return;
        $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $estudiante = $manager->getRepository('AppBundle:Estudiante')->find($row['usuario_from']);
            $hermano = $manager->getRepository('AppBundle:Estudiante')->find($row['usuario_to']);
            $estudiante->addMyBrother($hermano);
            $manager->persist($estudiante);
        }
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
