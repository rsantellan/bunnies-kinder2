<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * FacturaFinal
 *
 * @ORM\Table(name="factura_final", uniqueConstraints={@ORM\UniqueConstraint(name="monthly_yearly_user_index_idx", columns={"month", "year", "cuenta_id"})}, indexes={@ORM\Index(name="cuenta_id_idx", columns={"cuenta_id"})})
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Entity\FacturaFinalRepository")
 */
class FacturaFinal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=12, scale=2, nullable=false, options={"default": 0})
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
     * @ORM\Column(name="pago", type="boolean", nullable=false, options={"default": 0})
     */
    private $pago = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cancelado", type="boolean", nullable=false, options={"default": 0})
     */
    private $cancelado = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enviado", type="boolean", nullable=false, options={"default": 0})
     */
    private $enviado = false;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Cuenta", inversedBy="facturas")
     * @ORM\JoinColumn(name="cuenta_id", referencedColumnName="id", nullable=false)
     * 
     **/ 
    private $cuenta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechavencimiento", type="date", nullable=false)
     */
    private $fechavencimiento;

    /**
     * @var float
     *
     * @ORM\Column(name="pagadodeltotal", type="float", precision=12, scale=2, nullable=false, options={"default": 0})
     */
    private $pagadodeltotal;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * 
     * @ORM\OneToMany(targetEntity="FacturaFinalDetalle", mappedBy="factura", cascade={"remove"})
     *
     */
    private $facturaFinalDetalles;

    
    /**
     * @ORM\OneToMany(targetEntity="facturaEstudiante", mappedBy="facturaFinal")
     **/
    private $facturasEstudiantes;
    

    /**
     * Set id
     *
     * @return integer 
     */
    public function setId($id)
    {
        $this->id = $id;
        return  $this;
    }
    
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
     * @return FacturaFinal
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
     * @return FacturaFinal
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
     * @return FacturaFinal
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
     * @return FacturaFinal
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
     * @return FacturaFinal
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
     * @return FacturaFinal
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
     * Set fechavencimiento
     *
     * @param \DateTime $fechavencimiento
     * @return FacturaFinal
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
     * @return FacturaFinal
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
     * @return FacturaFinal
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
     * @return FacturaFinal
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

    /**
     * Set cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     * @return FacturaFinal
     */
    public function setCuenta(\AppBundle\Entity\Cuenta $cuenta = null)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta
     *
     * @return \AppBundle\Entity\Cuenta 
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Add facturaFinalDetalles
     *
     * @param \AppBundle\Entity\FacturaFinalDetalle $facturaFinalDetalles
     * @return FacturaFinal
     */
    public function addFacturaFinalDetalle(\AppBundle\Entity\FacturaFinalDetalle $facturaFinalDetalles)
    {
        $this->facturaFinalDetalles[] = $facturaFinalDetalles;

        return $this;
    }

    /**
     * Remove facturaFinalDetalles
     *
     * @param \AppBundle\Entity\FacturaFinalDetalle $facturaFinalDetalles
     */
    public function removeFacturaFinalDetalle(\AppBundle\Entity\FacturaFinalDetalle $facturaFinalDetalles)
    {
        $this->facturaFinalDetalles->removeElement($facturaFinalDetalles);
    }

    /**
     * Get facturaFinalDetalles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFacturaFinalDetalles()
    {
        return $this->facturaFinalDetalles;
    }

    /**
     * Add facturaEstudiante
     *
     * @param \AppBundle\Entity\FacturaEstudiante $facturaEstudiante
     * @return FacturaFinal
     */
    public function addFacturaEstudiante(\AppBundle\Entity\FacturaEstudiante $facturaEstudiante)
    {
        $this->facturaEstudiante[] = $facturaEstudiante;

        return $this;
    }

    /**
     * Remove facturaEstudiante
     *
     * @param \AppBundle\Entity\FacturaEstudiante $facturaEstudiante
     */
    public function removeFacturaEstudiante(\AppBundle\Entity\FacturaEstudiante $facturaEstudiante)
    {
        $this->facturaEstudiante->removeElement($facturaEstudiante);
    }

    /**
     * Get facturaEstudiante
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFacturaEstudiante()
    {
        return $this->facturaEstudiante;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->facturaFinalDetalles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->facturaEstudiante = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add facturasEstudiantes
     *
     * @param \AppBundle\Entity\facturaEstudiante $facturasEstudiantes
     * @return FacturaFinal
     */
    public function addFacturasEstudiante(\AppBundle\Entity\facturaEstudiante $facturasEstudiantes)
    {
        $this->facturasEstudiantes[] = $facturasEstudiantes;

        return $this;
    }

    /**
     * Remove facturasEstudiantes
     *
     * @param \AppBundle\Entity\facturaEstudiante $facturasEstudiantes
     */
    public function removeFacturasEstudiante(\AppBundle\Entity\facturaEstudiante $facturasEstudiantes)
    {
        $this->facturasEstudiantes->removeElement($facturasEstudiantes);
    }

    /**
     * Get facturasEstudiantes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFacturasEstudiantes()
    {
        return $this->facturasEstudiantes;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calculateDifference()
    {
      if(!$this->getCancelado())
      {
        $this->getCuenta()->setDebe($this->getCuenta()->getDebe() + $this->getTotal());
      }
    }    
}
