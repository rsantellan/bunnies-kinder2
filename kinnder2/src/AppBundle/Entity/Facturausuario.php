<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Facturausuario
 *
 * @ORM\Table(name="facturaUsuario", uniqueConstraints={@ORM\UniqueConstraint(name="monthly_yearly_user_index_idx", columns={"month", "year", "usuario_id"})}, indexes={@ORM\Index(name="usuario_id_idx", columns={"usuario_id"})})
 * @ORM\Entity
 */
class Facturausuario
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
     * 
     * @ORM\ManyToOne(targetEntity="Estudiante", inversedBy="facturas")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     * 
     **/      
    private $estudiante;

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
     * @ORM\Column(name="enviado", type="boolean", nullable=false, options={"default": 0})
     */
    private $enviado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pago", type="boolean", nullable=false, options={"default": 0})
     */
    private $pago;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cancelado", type="boolean", nullable=false, options={"default": 0})
     */
    private $cancelado;

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
     * 
     * @ORM\OneToMany(targetEntity="Facturausuariodetalle", mappedBy="factura")
     *
     */    
    private $facturaDetalles;

    /**
     * @ORM\ManyToMany(targetEntity="Facturafinal", inversedBy="facturasUsuarios")
     * @ORM\JoinTable(name="facturausuariofinal",
     *      joinColumns={@ORM\JoinColumn(name="factura_usuario_id", referencedColumnName="id", nullable=false)},
     *      inverseJoinColumns={@ORM\JoinColumn(name="factura_final_id", referencedColumnName="id", nullable=false)}
     *      )
     **/    
    private $facturasFinales;
    
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
     * @return Facturausuario
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
     * @return Facturausuario
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
     * @return Facturausuario
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
     * Set enviado
     *
     * @param boolean $enviado
     * @return Facturausuario
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
     * Set pago
     *
     * @param boolean $pago
     * @return Facturausuario
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
     * @return Facturausuario
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
     * Set fechavencimiento
     *
     * @param \DateTime $fechavencimiento
     * @return Facturausuario
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Facturausuario
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
     * @return Facturausuario
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
     * Add facturaDetalles
     *
     * @param \AppBundle\Entity\Facturausuariodetalle $facturaDetalles
     * @return Facturausuario
     */
    public function addFacturaDetalle(\AppBundle\Entity\Facturausuariodetalle $facturaDetalles)
    {
        $this->facturaDetalles[] = $facturaDetalles;

        return $this;
    }

    /**
     * Remove facturaDetalles
     *
     * @param \AppBundle\Entity\Facturausuariodetalle $facturaDetalles
     */
    public function removeFacturaDetalle(\AppBundle\Entity\Facturausuariodetalle $facturaDetalles)
    {
        $this->facturaDetalles->removeElement($facturaDetalles);
    }

    /**
     * Get facturaDetalles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFacturaDetalles()
    {
        return $this->facturaDetalles;
    }

    /**
     * Add facturasFinales
     *
     * @param \AppBundle\Entity\Facturafinal $facturasFinales
     * @return Facturausuario
     */
    public function addFacturasFinale(\AppBundle\Entity\Facturafinal $facturasFinales)
    {
        $this->facturasFinales[] = $facturasFinales;

        return $this;
    }

    /**
     * Remove facturasFinales
     *
     * @param \AppBundle\Entity\Facturafinal $facturasFinales
     */
    public function removeFacturasFinale(\AppBundle\Entity\Facturafinal $facturasFinales)
    {
        $this->facturasFinales->removeElement($facturasFinales);
    }

    /**
     * Get facturasFinales
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFacturasFinales()
    {
        return $this->facturasFinales;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->facturaDetalles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->facturasFinales = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set estudiante
     *
     * @param \AppBundle\Entity\Estudiante $estudiante
     * @return Facturausuario
     */
    public function setEstudiante(\AppBundle\Entity\Estudiante $estudiante = null)
    {
        $this->estudiante = $estudiante;

        return $this;
    }

    /**
     * Get estudiante
     *
     * @return \AppBundle\Entity\Estudiante 
     */
    public function getEstudiante()
    {
        return $this->estudiante;
    }
}
