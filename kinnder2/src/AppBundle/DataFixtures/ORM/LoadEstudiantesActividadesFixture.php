<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\DataFixtures\DataFixturesConstants;

/**
 * Description of LoadEstudiantesActividadesFixture.
 *
 * @author Rodrigo Santellan
 */
class LoadEstudiantesActividadesFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
   * @var ContainerInterface
   */
  private $container;

    public function getOrder()
    {
        return 5;
    }

    public function load(ObjectManager $manager)
    {
        $sql = 'select usuario_id, actividad_id from usuario_actividades order by usuario_id desc';
        $username = DataFixturesConstants::DBUSER;
        $password = DataFixturesConstants::DBPASS;
        $database = DataFixturesConstants::DBSCHEMA;

        return;
        $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $actividades = $manager->getRepository('AppBundle:Actividad')->findAll();
        $actividadesList = array();
        foreach ($actividades as $actividad) {
            $actividadesList[$actividad->getId()] = $actividad;
        }
        $estudianteId = null;
        $estudiante = null;
        while ($row = $stmt->fetch()) {
            $usuarioId = $row['usuario_id'];
            $actividadId = $row['actividad_id'];
            if ($estudianteId != $usuarioId) {
                if ($estudiante != null) {
                    $manager->persist($estudiante);
                }
                $estudianteId = $usuarioId;
                $estudiante = $manager->getRepository('AppBundle:Estudiante')->find($estudianteId);
            }
            $estudiante->addActividade($actividadesList[$actividadId]);
        }
        if ($estudiante != null) {
            $manager->persist($estudiante);
        }
        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
