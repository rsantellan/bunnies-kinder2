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
     * 
     * @ORM\OneToMany(targetEntity="Cobro", mappedBy="cuenta")
     *
     */
    private $cobros;
    
    /**
     * @ORM\ManyToMany(targetEntity="Progenitor", mappedBy="cuentas")
     **/
    private $progenitores;

    
    /**
     * @ORM\ManyToMany(targetEntity="Usuario", mappedBy="cuentas")
     **/
    private $usuarios;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Facturafinal", mappedBy="cuenta")
     *
     */
    private $facturas;    
    
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

    

    /**
     * Add cobros
     *
     * @param \AppBundle\Entity\Cobro $cobros
     * @return Cuenta
     */
    public function addCobro(\AppBundle\Entity\Cobro $cobros)
    {
        $this->cobros[] = $cobros;

        return $this;
    }

    /**
     * Remove cobros
     *
     * @param \AppBundle\Entity\Cobro $cobros
     */
    public function removeCobro(\AppBundle\Entity\Cobro $cobros)
    {
        $this->cobros->removeElement($cobros);
    }

    /**
     * Get cobros
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCobros()
    {
        return $this->cobros;
    }

    /**
     * Add progenitores
     *
     * @param \AppBundle\Entity\Progenitor $progenitores
     * @return Cuenta
     */
    public function addProgenitore(\AppBundle\Entity\Progenitor $progenitores)
    {
        $this->progenitores[] = $progenitores;

        return $this;
    }

    /**
     * Remove progenitores
     *
     * @param \AppBundle\Entity\Progenitor $progenitores
     */
    public function removeProgenitore(\AppBundle\Entity\Progenitor $progenitores)
    {
        $this->progenitores->removeElement($progenitores);
    }

    /**
     * Get progenitores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProgenitores()
    {
        return $this->progenitores;
    }

    /**
     * Add usuarios
     *
     * @param \AppBundle\Entity\Usuario $usuarios
     * @return Cuenta
     */
    public function addUsuario(\AppBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \AppBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(\AppBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cobros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->progenitores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add facturas
     *
     * @param \AppBundle\Entity\Facturafinal $facturas
     * @return Cuenta
     */
    public function addFactura(\AppBundle\Entity\Facturafinal $facturas)
    {
        $this->facturas[] = $facturas;

        return $this;
    }

    /**
     * Remove facturas
     *
     * @param \AppBundle\Entity\Facturafinal $facturas
     */
    public function removeFactura(\AppBundle\Entity\Facturafinal $facturas)
    {
        $this->facturas->removeElement($facturas);
    }

    /**
     * Get facturas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFacturas()
    {
        return $this->facturas;
    }
}
