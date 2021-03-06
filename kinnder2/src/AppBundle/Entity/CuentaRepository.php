<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CuentaRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CuentaRepository extends EntityRepository
{
    public function retrieveAllPendingDebts()
    {
        $sql = 'select c.id as cuentaId, c.diferencia, c.referenciabancaria, e.id as estudianteId, e.nombre, e.apellido, h.name as horario, cl.name as clase, e.egresado from cuenta c  inner join estudiante e on e.cuenta_id = c.id left outer join horario h on h.id = e.horario_id left outer join clase cl on cl.id = e.clase_id where c.diferencia > 0 order by e.apellido';
        $data = $this->getEntityManager()->getConnection()->executeQuery($sql);//->fetchAll();
        $returnList = array();
        while ($row = $data->fetch()) {
            $cuenta = new \stdClass();
            if (isset($returnList[$row['cuentaId']])) {
                $cuenta = $returnList[$row['cuentaId']];
            } else {
                $cuenta->cuentaId = $row['cuentaId'];
                $cuenta->diferencia = $row['diferencia'];
                $cuenta->referenciaBancaria = $row['referenciabancaria'];
                $cuenta->apellido = $row['apellido'];
                $cuenta->estudiantes = array();
            }
            $cuenta->estudiantes[] = array(
          'nombre' => $row['nombre'],
          'apellido' => $row['apellido'],
          'horario' => $row['horario'],
          'clase' => $row['clase'],
          'egresado' => $row['egresado'],
          );
          $returnList[$row['cuentaId']] = $cuenta;
        }

        return $returnList;
    }

    public function recheckDbData($cuentaId)
    {
        $sqlCobro = 'select sum(monto) as monto from cobro where cuenta_id = ?';
        $sqlFacturas = 'select sum(total) as total from factura_final where cuenta_id = ?';
        $cobro = $this->getEntityManager()->getConnection()->executeQuery($sqlCobro, array($cuentaId));
        $facturas = $this->getEntityManager()->getConnection()->executeQuery($sqlFacturas, array($cuentaId));
        $cobroRow = $cobro->fetch();
        $facturasRow = $facturas->fetch();
        $cobroNum = 0;
        $facturasNum = 0;
        if ($cobroRow['monto']) {
            $cobroNum = $cobroRow['monto'];
        }
        if ($facturasRow['total']) {
            $facturasNum = $facturasRow['total'];
        }

        return array(
      'cobro' => $cobroNum,
      'facturas' => $facturasNum,
    );
    }

    public function retrieveAllWithUsers()
    {
        $dql = 'select c, u from AppBundle:Cuenta c join c.estudiantes u';

        return $this->getEntityManager()
                ->createQuery($dql)
              ->getResult();
    }

    public function retrieveWithParents()
    {
        $dql = 'select c, p from AppBundle:Cuenta c join c.progenitores p';

        return $this->getEntityManager()
                ->createQuery($dql)
              ->getResult();
    }

    public function retrieveAllWithUsersAndParents($process = false)
    {
        $dql = 'select c, u, p from AppBundle:Cuenta c join c.estudiantes u join c.progenitores p order by c.diferencia desc';

        $data = $this->getEntityManager()
                ->createQuery($dql)
              ->getResult();

        if (!$process) {
            return $data;
        }
    }
}
