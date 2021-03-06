<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FacturaFinalRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FacturaFinalRepository extends EntityRepository
{
    public function retrieveFacturaFinalOfAccountPerMonthAndYear($account, $month, $year)
    {
        $dql = 'select f from AppBundle:FacturaFinal f where f.cuenta = :cuenta and f.month = :month and f.year = :year';

        return $this->getEntityManager()->createQuery($dql)->setParameters(array(
          'cuenta' => $account,
          'month' => $month,
          'year' => $year,
      ))->setMaxResults(1)->getOneOrNullResult();
    }

    public function retrieveUnpaidFacturasOfAccount($accountId, $orderDesc = true)
    {
        $dql = 'select f from AppBundle:FacturaFinal f where f.cuenta = :cuentaId and f.pago = false and f.cancelado = false order by f.year desc, f.month desc';
        if (!$orderDesc) {
            $dql = 'select f from AppBundle:FacturaFinal f where f.cuenta = :cuentaId and f.pago = false and f.cancelado = false order by f.year asc, f.month asc';
        }
        return $this->getEntityManager()->createQuery($dql)->setParameters(array(
          'cuentaId' => $accountId,
      ))->getResult();
    }

    public function retrievePaidFacturasOfAccount($accountId)
    {
        $dql = 'select f from AppBundle:FacturaFinal f where f.cuenta = :cuentaId and f.pago = true and f.cancelado = false order by f.year desc, f.month desc';

        return $this->getEntityManager()->createQuery($dql)->setParameters(array(
          'cuentaId' => $accountId,
      ))->getResult();
    }

    public function retrieveFacturasOfAccount($accountId)
    {
        $dql = 'select f, fd from AppBundle:FacturaFinal f join f.facturaFinalDetalles fd where f.cuenta = :cuentaId order by f.year desc, f.month desc';

        return $this->getEntityManager()->createQuery($dql)->setParameters(array(
              'cuentaId' => $accountId,
            ))->getResult();
    }
}
