<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Entity\Cuenta;
use AppBundle\Entity\Cobro;

use Symfony\Component\Form\Form;

/**
 * Description of CobroService.
 *
 * @author Rodrigo Santellan
 */
class CobroService
{
    protected $em;

    protected $logger;

    public function __construct(EntityManager $em, Logger $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->logger->addDebug('Starting cobros service');
    }

    public function saveCobroForm(Form $form, Cobro $cobro, $cuentaId)
    {
        $cuenta = $this->em->getRepository('AppBundle:Cuenta')->find($cuentaId);
        $result = false;
        $message = 'Ocurrion un error al guardar el cobro.';
        $amount = 0;
        $positive = false;
        if ($cuenta && $form->isValid()) {
            $cobro->setCuenta($cuenta);
            $this->em->persist($cobro);
            $cuenta->addPagoAmount($cobro->getMonto());
            $this->em->persist($cuenta);
            $this->em->flush();
            $result = true;
            $message = 'Cobro guardado con exito.';
            if ($cobro->getEnviado()) {
                //send email
                $message .= ' Email enviado correctamente';
            }
            $amount = $cuenta->getFormatedDiferencia();
            if ($cuenta->getDiferencia() < 0) {
                $positive = true;
            }
        }
        return array(
            'result' => $result,
            'message' => $message,
            'amount' => $amount,
            'positive' => $positive,
            'cuentaId' => $cuentaId,
            'cobro' => $cobro,
        );
    }
}
