<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
    private $pago;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cancelado", type="boolean", nullable=false, options={"default": 0})
     */
    private $cancelado;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enviado", type="boolean", nullable=false, options={"default": 0})
     */
    private $enviado;

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
     * @ORM\OneToMany(targetEntity="Facturafinaldetalle", mappedBy="factura")
     *
     */
    private $facturafinalDetalles;

    
    /**
     * @ORM\ManyToMany(targetEntity="Facturausuario", mappedBy="facturasFinales")
     **/
    private $facturasUsuarios;
    

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

    /**
     * Set cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     * @return Facturafinal
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
     * Add facturafinalDetalles
     *
     * @param \AppBundle\Entity\Facturafinaldetalle $facturafinalDetalles
     * @return Facturafinal
     */
    public function addFacturafinalDetalle(\AppBundle\Entity\Facturafinaldetalle $facturafinalDetalles)
    {
        $this->facturafinalDetalles[] = $facturafinalDetalles;

        return $this;
    }

    /**
     * Remove facturafinalDetalles
     *
     * @param \AppBundle\Entity\Facturafinaldetalle $facturafinalDetalles
     */
    public function removeFacturafinalDetalle(\AppBundle\Entity\Facturafinaldetalle $facturafinalDetalles)
    {
        $this->facturafinalDetalles->removeElement($facturafinalDetalles);
    }

    /**
     * Get facturafinalDetalles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFacturafinalDetalles()
    {
        return $this->facturafinalDetalles;
    }

    /**
     * Add facturasUsuarios
     *
     * @param \AppBundle\Entity\Facturausuario $facturasUsuarios
     * @return Facturafinal
     */
    public function addFacturasUsuario(\AppBundle\Entity\Facturausuario $facturasUsuarios)
    {
        $this->facturasUsuarios[] = $facturasUsuarios;

        return $this;
    }

    /**
     * Remove facturasUsuarios
     *
     * @param \AppBundle\Entity\Facturausuario $facturasUsuarios
     */
    public function removeFacturasUsuario(\AppBundle\Entity\Facturausuario $facturasUsuarios)
    {
        $this->facturasUsuarios->removeElement($facturasUsuarios);
    }

    /**
     * Get facturasUsuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFacturasUsuarios()
    {
        return $this->facturasUsuarios;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->facturafinalDetalles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->facturasUsuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
