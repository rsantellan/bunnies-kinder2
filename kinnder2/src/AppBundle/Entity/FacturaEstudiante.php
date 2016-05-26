<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * FacturaEstudiante.
 *
 * @ORM\Table(name="factura_estudiante", uniqueConstraints={@ORM\UniqueConstraint(name="monthly_yearly_user_index_idx", columns={"month", "year", "estudiante_id"})}, indexes={@ORM\Index(name="estudiante_id_idx", columns={"estudiante_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FacturaEstudianteRepository")
 */
class FacturaEstudiante
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Estudiante", inversedBy="facturas")
     * @ORM\JoinColumn(name="estudiante_id", referencedColumnName="id", nullable=false)
     **/
    private $estudiante;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=12, scale=2, nullable=false, options={"default": 0})
     */
    private $total;

    /**
     * @var int
     *
     * @ORM\Column(name="month", type="integer", nullable=false)
     */
    private $month;

    /**
     * @var int
     *
     * @ORM\Column(name="year", type="integer", nullable=false)
     */
    private $year;

    /**
     * @var bool
     *
     * @ORM\Column(name="enviado", type="boolean", nullable=false, options={"default": 0})
     */
    private $enviado = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="pago", type="boolean", nullable=false, options={"default": 0})
     */
    private $pago = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="cancelado", type="boolean", nullable=false, options={"default": 0})
     */
    private $cancelado = false;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechavencimiento", type="date", nullable=false)
     */
    private $fechavencimiento;

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
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="FacturaEstudianteDetalle", mappedBy="factura", cascade={"remove"})
     */
    private $facturaDetalles;

    /**
     * @ORM\ManyToOne(targetEntity="FacturaFinal", inversedBy="facturasEstudiantes")
     * @ORM\JoinColumn(name="factura_final_id", referencedColumnName="id", nullable=true)
     **/
    private $facturaFinal;

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
     * Set total.
     *
     * @param float $total
     *
     * @return FacturaEstudiante
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total.
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set month.
     *
     * @param int $month
     *
     * @return FacturaEstudiante
     */
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month.
     *
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set year.
     *
     * @param int $year
     *
     * @return FacturaEstudiante
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year.
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set enviado.
     *
     * @param bool $enviado
     *
     * @return FacturaEstudiante
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

    /**
     * Set pago.
     *
     * @param bool $pago
     *
     * @return FacturaEstudiante
     */
    public function setPago($pago)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago.
     *
     * @return bool
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * Set cancelado.
     *
     * @param bool $cancelado
     *
     * @return FacturaEstudiante
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
     * Set fechavencimiento.
     *
     * @param \DateTime $fechavencimiento
     *
     * @return FacturaEstudiante
     */
    public function setFechavencimiento($fechavencimiento)
    {
        $this->fechavencimiento = $fechavencimiento;

        return $this;
    }

    /**
     * Get fechavencimiento.
     *
     * @return \DateTime
     */
    public function getFechavencimiento()
    {
        return $this->fechavencimiento;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return FacturaEstudiante
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
     * @return FacturaEstudiante
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
     * Add facturaDetalles.
     *
     * @param \AppBundle\Entity\FacturaEstudianteDetalle $facturaDetalles
     *
     * @return FacturaEstudiante
     */
    public function addFacturaDetalle(\AppBundle\Entity\FacturaEstudianteDetalle $facturaDetalles)
    {
        $this->facturaDetalles[] = $facturaDetalles;

        return $this;
    }

    /**
     * Remove facturaDetalles.
     *
     * @param \AppBundle\Entity\FacturaEstudianteDetalle $facturaDetalles
     */
    public function removeFacturaDetalle(\AppBundle\Entity\FacturaEstudianteDetalle $facturaDetalles)
    {
        $this->facturaDetalles->removeElement($facturaDetalles);
    }

    /**
     * Get facturaDetalles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacturaDetalles()
    {
        return $this->facturaDetalles;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->facturaDetalles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set estudiante.
     *
     * @param \AppBundle\Entity\Estudiante $estudiante
     *
     * @return FacturaEstudiante
     */
    public function setEstudiante(\AppBundle\Entity\Estudiante $estudiante = null)
    {
        $this->estudiante = $estudiante;

        return $this;
    }

    /**
     * Get estudiante.
     *
     * @return \AppBundle\Entity\Estudiante
     */
    public function getEstudiante()
    {
        return $this->estudiante;
    }

    /**
     * Set facturaFinal.
     *
     * @param \AppBundle\Entity\FacturaFinal $facturaFinal
     *
     * @return FacturaEstudiante
     */
    public function setFacturaFinal(\AppBundle\Entity\FacturaFinal $facturaFinal)
    {
        $this->facturaFinal = $facturaFinal;

        return $this;
    }

    /**
     * Get facturaFinal.
     *
     * @return \AppBundle\Entity\FacturaFinal
     */
    public function getFacturaFinal()
    {
        return $this->facturaFinal;
    }
}
