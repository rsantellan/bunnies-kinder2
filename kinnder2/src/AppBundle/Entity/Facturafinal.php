<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facturafinal
 *
 * @ORM\Table(name="facturaFinal", uniqueConstraints={@ORM\UniqueConstraint(name="monthly_yearly_user_index_idx", columns={"month", "year", "cuenta_id"})}, indexes={@ORM\Index(name="cuenta_id_idx", columns={"cuenta_id"})})
 * @ORM\Entity
 */
class Facturafinal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=12, scale=2, nullable=false)
     */
    private $total;

    /**
     * @var integer
     *
     * @ORM\Column(name="month", type="integer", nullable=false)
     */
    private $month;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    private $year;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pago", type="boolean", nullable=false)
     */
    private $pago;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cancelado", type="boolean", nullable=false)
     */
    private $cancelado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enviado", type="boolean", nullable=false)
     */
    private $enviado;

    /**
     * @var integer
     *
     * @ORM\Column(name="cuenta_id", type="integer", nullable=false)
     */
    private $cuentaId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechavencimiento", type="date", nullable=false)
     */
    private $fechavencimiento;

    /**
     * @var float
     *
     * @ORM\Column(name="pagadodeltotal", type="float", precision=12, scale=2, nullable=false)
     */
    private $pagadodeltotal;

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
     * Set total
     *
     * @param float $total
     * @return Facturafinal
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return float 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set month
     *
     * @param integer $month
     * @return Facturafinal
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return integer 
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set year
     *
     * @param integer $year
     * @return Facturafinal
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set pago
     *
     * @param boolean $pago
     * @return Facturafinal
     */
    public function setPago($pago)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago
     *
     * @return boolean 
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * Set cancelado
     *
     * @param boolean $cancelado
     * @return Facturafinal
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;

        return $this;
    }

    /**
     * Get cancelado
     *
     * @return boolean 
     */
    public function getCancelado()
    {
        return $this->cancelado;
    }

    /**
     * Set enviado
     *
     * @param boolean $enviado
     * @return Facturafinal
     */
    public function setEnviado($enviado)
    {
        $this->enviado = $enviado;

        return $this;
    }

    /**
     * Get enviado
     *
     * @return boolean 
     */
    public function getEnviado()
    {
        return $this->enviado;
    }

    /**
     * Set cuentaId
     *
     * @param integer $cuentaId
     * @return Facturafinal
     */
    public function setCuentaId($cuentaId)
    {
        $this->cuentaId = $cuentaId;

        return $this;
    }

    /**
     * Get cuentaId
     *
     * @return integer 
     */
    public function getCuentaId()
    {
        return $this->cuentaId;
    }

    /**
     * Set fechavencimiento
     *
     * @param \DateTime $fechavencimiento
     * @return Facturafinal
     */
    public function setFechavencimiento($fechavencimiento)
    {
        $this->fechavencimiento = $fechavencimiento;

        return $this;
    }

    /**
     * Get fechavencimiento
     *
     * @return \DateTime 
     */
    public function getFechavencimiento()
    {
        return $this->fechavencimiento;
    }

    /**
     * Set pagadodeltotal
     *
     * @param float $pagadodeltotal
     * @return Facturafinal
     */
    public function setPagadodeltotal($pagadodeltotal)
    {
        $this->pagadodeltotal = $pagadodeltotal;

        return $this;
    }

    /**
     * Get pagadodeltotal
     *
     * @return float 
     */
    public function getPagadodeltotal()
    {
        return $this->pagadodeltotal;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Facturafinal
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
     * @return Facturafinal
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
