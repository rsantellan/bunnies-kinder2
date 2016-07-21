<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Actividad;
use AppBundle\Entity\Descuento;
use AppBundle\Entity\Costos;
use AppBundle\Entity\Estudiante;
use AppBundle\Entity\Colegio;
use AppBundle\Entity\SociedadMedica;
use AppBundle\Entity\EmergenciaMedica;
use FOS\UserBundle\Doctrine\UserManager;

/**
 * Description of ActividadMigrationService.
 *
 * @author Rodrigo Santellan
 */
class MigrationService
{
    protected $em;
    protected $logger;
    protected $oldDb;
    protected $oldDbUser;
    protected $oldDbPassword;
    protected $cuentaService;
    protected $newsLetterSyncService;
    protected $facturasServices;

    public function __construct(EntityManager $em, Logger $logger, $oldDb, $oldDbUser, $oldDbPassword, CuentasService $cuentaService, NewsletterSyncService $newsLetterSyncService, UserManager $userManager, FacturasManager $facturasManager)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->logger->addDebug('Actividades migration service');
        $this->oldDb = $oldDb;
        $this->oldDbUser = $oldDbUser;
        $this->oldDbPassword = $oldDbPassword;
        $this->cuentaService = $cuentaService;
        $this->newsLetterSyncService = $newsLetterSyncService;
        $this->userManager = $userManager;
        $this->facturasServices = $facturasManager;
    }

    private function getConn()
    {
        // A possible host is 192.168.100.124
        $host = 'localhost';
        return new \PDO(sprintf('mysql:host=%s;dbname=%s', $host, $this->oldDb), $this->oldDbUser, $this->oldDbPassword, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    private function retrieveOldActivity($id)
    {
        $sql = 'select id, nombre, costo, horario, md_news_letter_group_id from actividades where id = ?';
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));

        return $stmt->fetch();
    }

    public function updateActivity($id)
    {
        $row = $this->retrieveOldActivity($id);
        if (!$row) {
            return;
        }
        $activity = $this->em->getRepository('AppBundle:Actividad')->findOneBy(
              array(
                  'oldId' => $row['id'],
              )
          );
        if (!$activity) {
            $activity = new Actividad();
        }
        $activity->setCosto($row['costo']);
        $activity->setHorario($row['horario']);
        $activity->setNombre(trim($row['nombre']));
        $activity->setOldId($id);
        $this->em->persist($activity);
        $activity->setNewsLetterGroup($this->newsLetterSyncService->updateOrCreateActivityGroup(trim($row['nombre'])));
        $this->em->persist($activity);
        $this->em->flush();
        foreach ($activity->getEstudiantes() as $estudiante) {
            $this->facturasServices->generateUserAndFinalBill($estudiante);
        }

        return true;
    }

    public function removeActivity($id)
    {
        $activity = $this->em->getRepository('AppBundle:Actividad')->findOneBy(
              array(
                  'oldId' => $id,
              )
          );
        if ($activity) {
            $this->em->remove($activity->getNewsLetterGroup());
            $this->em->remove($activity);
            $this->em->flush();
        }

        return true;
    }

    private function retrieveOldDiscount($id)
    {
        $sql = 'select id, cantidad_de_hermanos, porcentaje from descuentos where id = ?';
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));

        return $stmt->fetch();
    }

    public function updateDiscount($id)
    {
        $row = $this->retrieveOldDiscount($id);
        if (!$row) {
            return;
        }
        $descuento = $this->em->getRepository('AppBundle:Descuento')->findOneBy(
                array(
                    'cantidadDeHermanos' => $row['cantidad_de_hermanos'],
                )
            );
        if (!$descuento) {
            $descuento = new Descuento();
        }
        $descuento->setId($row['id']);
        $descuento->setCantidadDeHermanos($row['cantidad_de_hermanos']);
        $descuento->setPorcentaje($row['porcentaje']);
        $this->em->persist($descuento);
        $this->em->flush();
    }

    public function removeDiscount($id)
    {
        $row = $this->retrieveOldDiscount($id);
        if (!$row) {
            return;
        }
        $descuento = $this->em->getRepository('AppBundle:Descuento')->findOneBy(
                array(
                    'cantidadDeHermanos' => $row['cantidad_de_hermanos'],
                )
            );
        if ($descuento) {
            $this->em->remove($descuento);
            $this->em->flush();
        }

        return true;
    }

    public function updateCostos()
    {
        $costos = $this->em->createQuery('SELECT c FROM AppBundle:Costos c')->setMaxResults(1)->getOneOrNullResult();
        if (!$costos) {
            $costos = new Costos();
        }
        $conn = $this->getConn();
        $sqlCostos = 'select matricula, matutino, vespertino, doble_horario from costos limit 1';
        $stmtCostos = $conn->prepare($sqlCostos);
        $stmtCostos->execute();
        $rowCostos = $stmtCostos->fetch();

        $costos->setMatricula($rowCostos['matricula']);
        $costos->setMatutino($rowCostos['matutino']);
        $costos->setVespertino($rowCostos['vespertino']);
        $costos->setDobleHorario($rowCostos['doble_horario']);
        $this->em->persist($costos);
        $this->em->flush();

        return true;
    }

    private function retrieveOldStudent($id)
    {
        $sql = 'select id, nombre, apellido, fecha_nacimiento, anio_ingreso, sociedad, referencia_bancaria, emergencia_medica, horario, futuro_colegio, descuento, clase, egresado from usuario where id = ?';
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));

        return $stmt->fetch();
    }

    private function retrieveOldStudentActivities($id)
    {
        $sql = 'select actividad_id from usuario_actividades where usuario_id = ?';
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));

        return $stmt->fetchAll();
    }

    public function updateStudent($id)
    {
        $row = $this->retrieveOldStudent($id);
        if (!$row) {
            return;
        }

        $estudiante = $this->em->getRepository('AppBundle:Estudiante')->findOneBy(
                array(
                    'oldId' => $row['id'],
                )
            );
        $isUpdate = true;
        if (!$estudiante) {
            $estudiante = new Estudiante();
            $isUpdate = false;
        }
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $fechaNacimiento = $row['fecha_nacimiento'];
        $anioIngreso = $row['anio_ingreso'];
        $sociedad = $row['sociedad'];
        $referencia_bancaria = $row['referencia_bancaria'];
        $emergencia_medica = $row['emergencia_medica'];
        $horario = $row['horario'];
        $futuro_colegio = $row['futuro_colegio'];
        $descuento = $row['descuento'];
        $clase = $row['clase'];
        $egresado = $row['egresado'];

        $estudiante->setAnioIngreso($anioIngreso);
        $estudiante->setApellido($apellido);
        $estudiante->setDescuento($descuento);
        $estudiante->setEgresado($egresado);
        if ($fechaNacimiento) {
            $estudiante->setFechaNacimiento(new \DateTime($fechaNacimiento));
        }

        $estudiante->setNombre($nombre);
        $estudiante->setReferenciaBancaria($referencia_bancaria);
        $estudiante->setActive(true);
        $estudiante->setOldId($row['id']);

        if ($horario == 'doble_horario') {
            $horario = 'Doble Horario';
        }

        $dbHorario = $this->em->getRepository('AppBundle:Horario')->findOneBy(array('name' => ucfirst($horario)));

        $estudiante->setHorario($dbHorario);

        $dbClase = $this->em->getRepository('AppBundle:Clase')->findOneBy(array('name' => ucfirst($clase)));
        $estudiante->setClase($dbClase);
        if ($futuro_colegio != '') {
            $dbColegio = $this->em->getRepository('AppBundle:Colegio')->findOneBy(array('name' => $futuro_colegio));
            if (!$dbColegio) {
                $dbColegio = new Colegio();
                $dbColegio->setName($futuro_colegio);
                $this->em->persist($dbColegio);
            }
            $estudiante->setFuturoColegio($dbColegio);
        }

        if ($sociedad != '') {
            $dbSociedad = $this->em->getRepository('AppBundle:SociedadMedica')->findOneBy(array('name' => $sociedad));
            if (!$dbSociedad) {
                $dbSociedad = new SociedadMedica();
                $dbSociedad->setName($sociedad);
                $this->em->persist($dbSociedad);
            }
            $estudiante->setSociedadMedica($dbSociedad);
        }

        if ($emergencia_medica != '') {
            $dbEmergenciaMedica = $this->em->getRepository('AppBundle:EmergenciaMedica')->findOneBy(array('name' => $emergencia_medica));
            if (!$dbEmergenciaMedica) {
                $dbEmergenciaMedica = new EmergenciaMedica();
                $dbEmergenciaMedica->setName($emergencia_medica);
                $this->em->persist($dbEmergenciaMedica);
            }
            $estudiante->setEmergenciaMedica($dbEmergenciaMedica);
        }
        $oldDbActivities = $this->retrieveOldStudentActivities($id);
        $activitiesList = new ArrayCollection();
        foreach ($oldDbActivities as $rowActivity) {
            $activity = $this->em->getRepository('AppBundle:Actividad')->findOneBy(
              array(
                  'oldId' => $rowActivity['actividad_id'],
              )
          );
            if ($activity) {
                $activitiesList->add($activity);
            }
        }
        $estudiante->mergeActividades($activitiesList);
        $this->em->persist($estudiante);
        $this->em->flush();
        if (!$isUpdate) {
            $this->cuentaService->updateOrCreateCuenta($estudiante);
        }
        $this->facturasServices->generateUserAndFinalBill($estudiante);
        $this->newsLetterSyncService->updateEstudianteRelations($estudiante);

        return true;
    }

    public function disableEstudiante($id)
    {
        $estudiante = $this->em->getRepository('AppBundle:Estudiante')->findOneBy(
                array(
                    'oldId' => $id,
                )
            );
        $progenitores = $estudiante->getProgenitores();
        $this->em->remove($estudiante);
        $this->em->flush();
        foreach ($progenitores as $progenitor) {
            $this->newsLetterSyncService->updateProgenitorRelations($progenitor);
        }

        return true;
    }

    private function retrieveOldParent($id)
    {
        $sql = 'select id, nombre, direccion, telefono, celular, mail, clave from progenitor where id = ?';
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));

        return $stmt->fetch();
    }

    public function updateParent($id)
    {
        $row = $this->retrieveOldParent($id);
        if (!$row) {
            return;
        }
        $progenitor = $this->em->getRepository('AppBundle:Progenitor')->findOneBy(
                array(
                    'oldId' => $row['id'],
                )
            );
        $isUpdate = true;
        if (!$progenitor) {
            $progenitor = $this->userManager->createUser();
            $isUpdate = false;
        }
        $nombre = $row['nombre'];
        $direccion = $row['direccion'];
        $telefono = $row['telefono'];
        $celular = $row['celular'];
        $mail = trim($row['mail']);
        $progenitor->setUsername($mail);
        $progenitor->setEmail($mail);
        $progenitor->setPlainPassword('bunnyskinder');
        $progenitor->setEnabled(true);
        $progenitor->setSuperAdmin(false);
        $progenitor->setNombre($nombre);
        $progenitor->setDireccion($direccion);
        $progenitor->setTelefono($telefono);
        $progenitor->setCelular($celular);
        $progenitor->setOldId($row['id']);
        $this->em->persist($progenitor);
        $this->em->flush();
        if (!$isUpdate) {
            $newsletterUser = $this->em->getRepository('MaithNewsletterBundle:User')->findOneBy(
          array(
              'email' => $mail,
          )
      );
            if (!$newsletterUser) {
                $newsletterUser = new \Maith\NewsletterBundle\Entity\User();
                $newsletterUser->setEmail($mail);
            }
            $newsletterUser->setActive(true);
            $this->em->persist($newsletterUser);
            $progenitor->setNewsletterUser($newsletterUser);
            $this->em->persist($progenitor);
            $this->em->flush();
        }
    }

    public function removeParent($id)
    {
        $progenitor = $this->em->getRepository('AppBundle:Progenitor')->findOneBy(
                array(
                    'oldId' => $id,
                )
            );
        if ($progenitor) {
            $this->em->remove($progenitor);
            $this->em->flush();
        }

        return true;
    }
    public function updateUserActivity($userId, $activityId)
    {
        $estudiante = $this->em->getRepository('AppBundle:Estudiante')->findOneBy(
                array(
                    'oldId' => $userId,
                )
            );
        $activity = $this->em->getRepository('AppBundle:Actividad')->findOneBy(
              array(
                  'oldId' => $activityId,
              )
          );
        if ($estudiante && $activity) {
            $found = false;
            foreach ($estudiante->getActividades() as $act) {
                if ($act->getId() == $activity->getId()) {
                    $found = true;
                }
            }
            if (!$found) {
                $estudiante->addActividade($activity);
                $this->em->persist($estudiante);
                $this->em->persist($activity);
                $this->em->flush();
            }
            $this->newsLetterSyncService->updateEstudianteRelations($estudiante);
            $this->facturasServices->generateUserAndFinalBill($estudiante);
        }
    }

    public function removeUserActivity($userId, $activityId)
    {
        $estudiante = $this->em->getRepository('AppBundle:Estudiante')->findOneBy(
                array(
                    'oldId' => $userId,
                )
            );
        $activity = $this->em->getRepository('AppBundle:Actividad')->findOneBy(
              array(
                  'oldId' => $activityId,
              )
          );
        if ($estudiante && $activity) {
            $estudiante->removeActividade($activity);
            $this->em->persist($estudiante);
            $this->em->flush();
            $this->newsLetterSyncService->updateEstudianteRelations($estudiante);
            $this->facturasServices->generateUserAndFinalBill($estudiante);
        }
    }

    public function updateUserParent($userId, $parentId)
    {
        $estudiante = $this->em->getRepository('AppBundle:Estudiante')->findOneBy(
                array(
                    'oldId' => $userId,
                )
            );
        $progenitor = $this->em->getRepository('AppBundle:Progenitor')->findOneBy(
                array(
                    'oldId' => $parentId,
                )
            );
        if ($estudiante && $progenitor) {
            $found = false;
            foreach ($estudiante->getProgenitores() as $act) {
                if ($act->getId() == $progenitor->getId()) {
                    $found = true;
                }
            }
            if (!$found) {
                foreach ($progenitor->getEstudiantes() as $auxEstudiante) {
                    if ($estudiante->getReferenciaBancaria() != $auxEstudiante->getReferenciaBancaria()) {
                        throw new \Exception('No se puede agregar este padre por que tiene un hijo con distinta referencia bancaria');
                    }
                }
                $estudiante->addProgenitore($progenitor);
                $progenitor->addEstudiante($estudiante);
                $progenitor->setCuenta($estudiante->getCuenta());
                $this->em->persist($estudiante);
                $this->em->persist($progenitor);
                $this->em->flush();
            }
            $this->newsLetterSyncService->updateProgenitorRelations($progenitor);
        }
    }

    public function removeUserParent($userId, $parentId)
    {
        $estudiante = $this->em->getRepository('AppBundle:Estudiante')->findOneBy(
                array(
                    'oldId' => $userId,
                )
            );
        $progenitor = $this->em->getRepository('AppBundle:Progenitor')->findOneBy(
                array(
                    'oldId' => $parentId,
                )
            );
        if ($estudiante && $progenitor) {
            $estudiante->removeProgenitore($progenitor);
            $progenitor->removeEstudiante($estudiante);
            $this->em->persist($progenitor);
            $this->em->persist($estudiante);
            $this->em->flush();
            $this->newsLetterSyncService->updateEstudianteRelations($estudiante);
            $this->newsLetterSyncService->updateProgenitorRelations($progenitor);
        }
    }

    public function updatePayment($paymentId)
    {
        $row = $this->retrieveOldPayment($paymentId);
        if (!$row) {
            return;
        }

        $cuenta = $this->em->getRepository('AppBundle:Cuenta')->findOneBy(
                array(
                    'referenciabancaria' => $row['referenciabancaria'],
                )
            );
        $this->cuentaService->addCobroToCuenta($cuenta, $row['monto'], new \DateTime($row['fecha']));

        return true;
    }

    public function cancelBilling($account, $month, $year)
    {
        $cuenta = $this->em->getRepository('AppBundle:Cuenta')->findOneBy(
                array(
                    'referenciabancaria' => $account,
                )
            );
        foreach ($cuenta->getFacturas() as $factura) {
            if ($factura->getMonth() == $month && $factura->getYear() == $year) {
                $this->facturasServices->cancelFactura($factura);
            }
        }

        return true;
    }

    private function retrieveOldPayment($id)
    {
        $sql = 'select c.fecha, c.monto, cu.referenciabancaria from cobro c inner join cuenta cu on c.cuenta_id = cu.id where c.id = ?';
        $conn = $this->getConn();
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($id));

        return $stmt->fetch();
    }

    public function compareCuentas()
    {
        throw new \Exception("Dont call me please!");
        
    }
}
