<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Cobro.
 *
 * @ORM\Table(name="cobro", indexes={@ORM\Index(name="cuenta_id_idx", columns={"cuenta_id"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CobrosRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Cobro
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Cuenta", inversedBy="cobros")
     * @ORM\JoinColumn(name="cuenta_id", referencedColumnName="id", nullable=false)
     **/
    private $cuenta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var float
     *
     * @ORM\Column(name="monto", type="float", precision=12, scale=2, nullable=false, options={"default": 0})
     */
    private $monto;

    /**
     * @var bool
     *
     * @ORM\Column(name="cancelado", type="boolean", nullable=false, options={"default": 0})
     */
    private $cancelado = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="enviado", type="boolean", nullable=false, options={"default": 0})
     */
    private $enviado = false;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;


    public function __construct()
    {
        $this->setFecha(new \DateTime());
    }

    /**
     * Set id.
     *
     * @return int
     */
    public function setId($id)
    {
        $this->id = $id;

        return  $this;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha.
     *
     * @param \DateTime $fecha
     *
     * @return Cobro
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha.
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set monto.
     *
     * @param float $monto
     *
     * @return Cobro
     */
    public function setMonto($monto)
    {
        $this->monto = $monto;

        return $this;
    }

    /**
     * Get monto.
     *
     * @return float
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Cobro
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Cobro
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set cuenta.
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     *
     * @return Cobro
     */
    public function setCuenta(\AppBundle\Entity\Cuenta $cuenta = null)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta.
     *
     * @return \AppBundle\Entity\Cuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calculateDifference()
    {
    }

    /**
     * Set cancelado.
     *
     * @param bool $cancelado
     *
     * @return Cobro
     */
    public function setCancelado($cancelado)
    {
        $this->cancelado = $cancelado;

        return $this;
    }

    /**
     * Get cancelado.
     *
     * @return bool
     */
    public function getCancelado()
    {
        return $this->cancelado;
    }

    /**
     * Set enviado.
     *
     * @param bool $enviado
     *
     * @return Cobro
     */
    public function setEnviado($enviado)
    {
        $this->enviado = $enviado;

        return $this;
    }

    /**
     * Get enviado.
     *
     * @return bool
     */
    public function getEnviado()
    {
        return $this->enviado;
    }
}
