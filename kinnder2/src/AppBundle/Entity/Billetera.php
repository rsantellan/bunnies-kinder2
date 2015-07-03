<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Billetera
 *
 * @ORM\Table(name="billetera")
 * @ORM\Entity
 */
class Billetera
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="credito", type="bigint", nullable=true)
     */
    private $credito;

    /**
     * @var integer
     *
     * @ORM\Column(name="deuda", type="bigint", nullable=true)
     */
    private $deuda;

    /**
     * @var integer
     *
     * @ORM\Column(name="impuesto", type="bigint", nullable=true)
     */
    private $impuesto;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set credito
     *
     * @param integer $credito
     * @return Billetera
     */
    public function setCredito($credito)
    {
        $this->credito = $credito;

        return $this;
    }

    /**
     * Get credito
     *
     * @return integer 
     */
    public function getCredito()
    {
        return $this->credito;
    }

    /**
     * Set deuda
     *
     * @param integer $deuda
     * @return Billetera
     */
    public function setDeuda($deuda)
    {
        $this->deuda = $deuda;

        return $this;
    }

    /**
     * Get deuda
     *
     * @return integer 
     */
    public function getDeuda()
    {
        return $this->deuda;
    }

    /**
     * Set impuesto
     *
     * @param integer $impuesto
     * @return Billetera
     */
    public function setImpuesto($impuesto)
    {
        $this->impuesto = $impuesto;

        return $this;
    }

    /**
     * Get impuesto
     *
     * @return integer 
     */
    public function getImpuesto()
    {
        return $this->impuesto;
    }
}
