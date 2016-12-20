<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;

use AppBundle\Entity\CronObject;


/**
 * Description of CronObjectService.
 *
 * @author Rodrigo Santellan
 */
class CronObjectService
{
    protected $em;

    protected $logger;

    protected $facturasManager;

    public function __construct(EntityManager $em, Logger $logger, FacturasManager $facturasManager)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->facturasManager = $facturasManager;
        $this->logger->addDebug('Starting crons service');
    }

    public function addCronOfType($type, $createdBy, $extraData = '')
    {
        $dql = 'select c from AppBundle:CronObject c where c.executed = false and c.type = :type';
        $cronObject = $this->em->createQuery($dql)->setParameters(array(
          'type' => $type,
        ))->setMaxResults(1)->getOneOrNullResult();
        if($cronObject){
            $this->logger->error(sprintf("Ya existe esta tarea para ejecutarse. User %s and type: %s", $createdBy, $type));
            throw new \Exception("Ya existe esta tarea para ejecutarse.");
        }
        $cronObject = new CronObject();
        $cronObject->setType($type);
        $cronObject->setExecuted(false);
        $cronObject->setCreatedBy($createdBy);
        $cronObject->setCreatedAt(new \DateTime());
        $cronObject->setRunningtime(0);
        $cronObject->setExtraData($extraData);
        switch($type){
            case CronObject::RECREATECOSTOS:
                $cronObject->setTypeName("Recreacion de costos");
            break;            
            case CronObject::RECREATEACTIVIDAD:
                $cronObject->setTypeName("Recreacion de actividad");
            break;
            default:
                $cronObject->setTypeName("indefinido");
            break;
        }
        $this->em->persist($cronObject);
        $this->em->flush();
        return true;
    }

    public function processOneCron()
    {
        $dql = 'select c from AppBundle:CronObject c where c.executed = false order by c.id asc';
        $cronObject = $this->em->createQuery($dql)
                        ->setMaxResults(1)
                        ->getOneOrNullResult();
        $message = 'No se pudo ejecutar el proceso';
        if($cronObject){
            switch($cronObject->getType()){
                case CronObject::RECREATECOSTOS:
                    $this->processRecreacionCostosCron($cronObject);
                    $message = 'Proceso de recreacion de costos fue ejecutado correctamente';
                break;
                case CronObject::RECREATEACTIVIDAD:
                    $this->processRecreacionActividadCron($cronObject);
                    $message = 'Proceso de recreacion de actividad fue ejecutado correctamente';
                break;
                default:
                    $this->logger->error('no type was defined for cron: %s', $cronObject->getId());
                break;
            }
        }
    }

    public function processRecreacionCostosCron(CronObject $cronObject){
        $startime = time();
        $filterBuilder = $this->em->getRepository('AppBundle:Estudiante')
          ->createQueryBuilder('e')
          ->select('e')
          ->andWhere('e.egresado = false');
        $estudiantes = $filterBuilder->getQuery()->getResult();
        foreach($estudiantes as $estudiante){
            $this->facturasManager->generateUserAndFinalBill($estudiante, null, null, true);
        }
        $cronObject->setRunningtime(time() - $startime);
        $cronObject->setExecuted(true);
        $this->em->persist($cronObject);
        $this->em->flush();
    }

    
    public function processRecreacionActividadCron(CronObject $cronObject){
        $startime = time();
        $filterBuilder = $this->em->getRepository('AppBundle:Estudiante')
          ->createQueryBuilder('e')
          ->select('e')
          ->leftJoin('e.actividades', 'a')
          ->andWhere('e.egresado = false')
          ->andWhere('a.id = :actividadId');
        $estudiantes = $filterBuilder->setParameters(array('actividadId' => $cronObject->getExtraData()))->getQuery()->getResult();
        foreach($estudiantes as $estudiante){
            $this->facturasManager->generateUserAndFinalBill($estudiante, null, null, true);
        }
        $cronObject->setRunningtime(time() - $startime);
        $cronObject->setExecuted(true);
        $this->em->persist($cronObject);
        $this->em->flush();
    }


}
