<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuenta
 *
 * @ORM\Table(name="cuenta")
 * @ORM\Entity
 */
class Cuenta
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
     * @var string
     *
     * @ORM\Column(name="referenciabancaria", type="string", length=64, nullable=false)
     */
    private $referenciabancaria;

    /**
     * @var float
     *
     * @ORM\Column(name="debe", type="float", precision=14, scale=2, nullable=true)
     */
    private $debe;

    /**
     * @var float
     *
     * @ORM\Column(name="pago", type="float", precision=14, scale=2, nullable=true)
     */
    private $pago;

    /**
     * @var float
     *
     * @ORM\Column(name="diferencia", type="float", precision=14, scale=2, nullable=true)
     */
    private $diferencia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;



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
     * Set referenciabancaria
     *
     * @param string $referenciabancaria
     * @return Cuenta
     */
    public function setReferenciabancaria($referenciabancaria)
    {
        $this->referenciabancaria = $referenciabancaria;

        return $this;
    }

    /**
     * Get referenciabancaria
     *
     * @return string 
     */
    public function getReferenciabancaria()
    {
        return $this->referenciabancaria;
    }

    /**
     * Set debe
     *
     * @param float $debe
     * @return Cuenta
     */
    public function setDebe($debe)
    {
        $this->debe = $debe;

        return $this;
    }

    /**
     * Get debe
     *
     * @return float 
     */
    public function getDebe()
    {
        return $this->debe;
    }

    /**
     * Set pago
     *
     * @param float $pago
     * @return Cuenta
     */
    public function setPago($pago)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago
     *
     * @return float 
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * Set diferencia
     *
     * @param float $diferencia
     * @return Cuenta
     */
    public function setDiferencia($diferencia)
    {
        $this->diferencia = $diferencia;

        return $this;
    }

    /**
     * Get diferencia
     *
     * @return float 
     */
    public function getDiferencia()
    {
        return $this->diferencia;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Cuenta
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Cuenta
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
