<?php

namespace Maith\ContableBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use AppBundle\DataFixtures\DataFixturesConstants;
use AppBundle\Entity\Facturausuario;
use AppBundle\Entity\Facturausuariodetalle;
use AppBundle\Entity\Facturafinal;
use AppBundle\Entity\Facturafinaldetalle;
/**
 * Description of LoadCuentasFacturasFixture
 *
 * @author Rodrigo Santellan
 */
class LoadCuentasFacturasFixture extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {

  /**
   * @var ContainerInterface
   */
  private $container;

  public function getOrder() {
	return 9;
  }

  public function load(ObjectManager $manager) {
    
	$sqlFacturaUsuario = 'select id, usuario_id, total, month, year, enviado, pago, cancelado, fechavencimiento from facturaUsuario order by usuario_id';
    $sqlFacturaUsuarioDetalle = 'select id, factura_id, description, amount from facturaUsuarioDetalle where factura_id = ?';
    
    $sqlFacturaFinal = 'select id, total, month, year, pago, cancelado, enviado, cuenta_id, fechavencimiento, pagadodeltotal from facturaFinal where id in (select factura_final_id from facturausuariofinal where factura_usuario_id = ?)';
    $sqlFacturaFinalDetalle = 'select id, factura_id, description, amount from facturaFinalDetalle where factura_id = ?';
    
    $username = DataFixturesConstants::DBUSER;
    $password = DataFixturesConstants::DBPASS;
    $database = DataFixturesConstants::DBSCHEMA;
    
    $conn = new \PDO(sprintf('mysql:host=localhost;dbname=%s', $database), $username, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $stmt = $conn->prepare($sqlFacturaUsuario);
    $stmt->execute();

    $stmtUsuarioDetalle = $conn->prepare($sqlFacturaUsuarioDetalle);
    $stmtFactura = $conn->prepare($sqlFacturaFinal);
    $stmtFacturaDetalle = $conn->prepare($sqlFacturaFinalDetalle);
    
    $metadata = $manager->getClassMetaData(get_class(new Facturausuario()));
    $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    
    $metadataDetalle = $manager->getClassMetaData(get_class(new Facturausuariodetalle()));
    $metadataDetalle->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    
    $metadataFactura = $manager->getClassMetaData(get_class(new Facturafinal()));
    $metadataFactura->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    
    $metadataFacturaDetalle = $manager->getClassMetaData(get_class(new Facturafinaldetalle()));
    $metadataFacturaDetalle->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
    $facturasList = array();
    
    while($row = $stmt->fetch())
    {
        // Adding cobro
        $facturaUsuario = new Facturausuario();
        $facturaUsuario->setId($row['id']);
        $fechavencimiento = $row['fechavencimiento'];
        if($fechavencimiento){
          $facturaUsuario->setFechavencimiento(new \DateTime($fechavencimiento));
        }
        $facturaUsuario->setCancelado($row['cancelado']);
        $facturaUsuario->setEnviado($row['enviado']);
        $facturaUsuario->setMonth($row['month']);
        $facturaUsuario->setPago($row['pago']);
        $facturaUsuario->setTotal($row['total']);
        $facturaUsuario->setYear($row['year']);
        
        $facturaUsuario->setEstudiante($manager->getRepository('AppBundle:Estudiante')->find($row['usuario_id']));
        $manager->persist($facturaUsuario);
        
        $stmtUsuarioDetalle->execute(array($row['id']));
        while($rowUsuarioDetalle = $stmtUsuarioDetalle->fetch()){
          $usuarioDetalle = new Facturausuariodetalle();
          $usuarioDetalle->setId($rowUsuarioDetalle['id']);
          $usuarioDetalle->setAmount($rowUsuarioDetalle['amount']);
          $usuarioDetalle->setDescription($rowUsuarioDetalle['description']);
          $usuarioDetalle->setFactura($facturaUsuario);
          $manager->persist($usuarioDetalle);
        }
        
        $stmtFactura->execute(array($row['id']));
        while($rowFactura = $stmtFactura->fetch()){
          if(!isset($facturasList[$rowFactura['id']]))
          {
            $facturaFinal = new Facturafinal();
            $facturaFinal->setCancelado($rowFactura['cancelado']);
            $facturaFinal->setCuenta($manager->getRepository('AppBundle:Cuenta')->find($rowFactura['cuenta_id']));
            $facturaFinal->setEnviado($rowFactura['enviado']);
            $fechavencimiento = $rowFactura['fechavencimiento'];
            if($fechavencimiento){
              $facturaFinal->setFechavencimiento(new \DateTime($fechavencimiento));
            }
            $facturaFinal->setId($rowFactura['id']);
            $facturaFinal->setMonth($rowFactura['month']);
            $facturaFinal->setPagadodeltotal($rowFactura['pagadodeltotal']);
            $facturaFinal->setPago($rowFactura['pago']);
            $facturaFinal->setTotal($rowFactura['total']);
            $facturaFinal->setYear($rowFactura['year']);
            $manager->persist($facturaFinal);
            $facturasList[$rowFactura['id']] = $facturaFinal;
            
            $stmtFacturaDetalle->execute($rowFactura['id']);
            while($rowDetalle = $stmtFacturaDetalle->fetch()){
              $facturaFinalDetalle = new Facturafinaldetalle();
              $facturaFinalDetalle->setAmount($rowDetalle['']);
              $facturaFinalDetalle->setDescription($rowDetalle);
              $facturaFinalDetalle->setFactura($facturaFinal);
              $facturaFinalDetalle->setId($rowDetalle);
            }
          }
          else
          {
            $facturaFinal = $facturasList[$rowFactura['id']];
          }
          
          $facturaUsuario->addFacturasFinale($facturaFinal);
        }
        $manager->persist($facturaUsuario);
        
        
    }
    $manager->flush();
    
  }

  public function setContainer(ContainerInterface $container = null) {
	$this->container = $container;
  }

}

