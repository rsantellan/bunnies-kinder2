<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Cuenta.
 *
 * @ORM\Table(name="cuenta")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CuentaRepository")
 */
class Cuenta
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
     * @var string
     *
     * @ORM\Column(name="referenciabancaria", type="string", length=64, nullable=false)
     */
    private $referenciabancaria;

    /**
     * @var float
     *
     * @ORM\Column(name="debe", type="float", precision=14, scale=2, nullable=true, options={"default": 0})
     */
    private $debe = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="pago", type="float", precision=14, scale=2, nullable=true, options={"default": 0})
     */
    private $pago = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="diferencia", type="float", precision=14, scale=2, nullable=true, options={"default": 0})
     */
    private $diferencia = 0;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Cobro", mappedBy="cuenta")
     */
    private $cobros;

    /**
     * @ORM\OneToMany(targetEntity="Progenitor", mappedBy="cuenta")
     **/
    private $progenitores;

    /**
     * @ORM\OneToMany(targetEntity="Estudiante", mappedBy="cuenta")
     **/
    private $estudiantes;

    /**
     * @ORM\OneToMany(targetEntity="FacturaFinal", mappedBy="cuenta")
     */
    private $facturas;

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
     * Set referenciabancaria.
     *
     * @param string $referenciabancaria
     *
     * @return Cuenta
     */
    public function setReferenciabancaria($referenciabancaria)
    {
        $this->referenciabancaria = $referenciabancaria;

        return $this;
    }

    /**
     * Get referenciabancaria.
     *
     * @return string
     */
    public function getReferenciabancaria()
    {
        return $this->referenciabancaria;
    }

    /**
     * Set debe.
     *
     * @param float $debe
     *
     * @return Cuenta
     */
    public function setDebe($debe)
    {
        $this->debe = $debe;

        return $this;
    }

    /**
     * Get debe.
     *
     * @return float
     */
    public function getDebe()
    {
        return $this->debe;
    }

    /**
     * Set pago.
     *
     * @param float $pago
     *
     * @return Cuenta
     */
    public function setPago($pago)
    {
        $this->pago = $pago;

        return $this;
    }

    /**
     * Get pago.
     *
     * @return float
     */
    public function getPago()
    {
        return $this->pago;
    }

    /**
     * Set diferencia.
     *
     * @param float $diferencia
     *
     * @return Cuenta
     */
    public function setDiferencia($diferencia)
    {
        $this->diferencia = $diferencia;

        return $this;
    }

    /**
     * Get diferencia.
     *
     * @return float
     */
    public function getDiferencia()
    {
        return $this->diferencia;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Cuenta
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
     * @return Cuenta
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
     * Add cobros.
     *
     * @param \AppBundle\Entity\Cobro $cobros
     *
     * @return Cuenta
     */
    public function addCobro(\AppBundle\Entity\Cobro $cobros)
    {
        $this->cobros[] = $cobros;

        return $this;
    }

    /**
     * Remove cobros.
     *
     * @param \AppBundle\Entity\Cobro $cobros
     */
    public function removeCobro(\AppBundle\Entity\Cobro $cobros)
    {
        $this->cobros->removeElement($cobros);
    }

    /**
     * Get cobros.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCobros()
    {
        return $this->cobros;
    }

    /**
     * Add progenitores.
     *
     * @param \AppBundle\Entity\Progenitor $progenitores
     *
     * @return Cuenta
     */
    public function addProgenitore(\AppBundle\Entity\Progenitor $progenitores)
    {
        $this->progenitores[] = $progenitores;

        return $this;
    }

    /**
     * Remove progenitores.
     *
     * @param \AppBundle\Entity\Progenitor $progenitores
     */
    public function removeProgenitore(\AppBundle\Entity\Progenitor $progenitores)
    {
        $this->progenitores->removeElement($progenitores);
    }

    /**
     * Get progenitores.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgenitores()
    {
        return $this->progenitores;
    }

    /**
     * Add facturas.
     *
     * @param \AppBundle\Entity\FacturaFinal $facturas
     *
     * @return Cuenta
     */
    public function addFactura(\AppBundle\Entity\FacturaFinal $facturas)
    {
        $this->facturas[] = $facturas;

        return $this;
    }

    /**
     * Remove facturas.
     *
     * @param \AppBundle\Entity\FacturaFinal $facturas
     */
    public function removeFactura(\AppBundle\Entity\FacturaFinal $facturas)
    {
        $this->facturas->removeElement($facturas);
    }

    /**
     * Get facturas.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacturas()
    {
        return $this->facturas;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->cobros = new \Doctrine\Common\Collections\ArrayCollection();
        $this->progenitores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->estudiantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->facturas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add estudiantes.
     *
     * @param \AppBundle\Entity\Estudiante $estudiantes
     *
     * @return Cuenta
     */
    public function addEstudiante(\AppBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes[] = $estudiantes;

        return $this;
    }

    /**
     * Remove estudiantes.
     *
     * @param \AppBundle\Entity\Estudiante $estudiantes
     */
    public function removeEstudiante(\AppBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes->removeElement($estudiantes);
    }

    /**
     * Get estudiantes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstudiantes()
    {
        return $this->estudiantes;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function calculateDifference()
    {
        $this->setDiferencia($this->getDebe() - $this->getPago());
    }

    public function __toString()
    {
        return $this->getReferenciabancaria();
    }

    public function getFormatedDiferencia()
    {
        if ($this->getDiferencia() < 0) {
            return number_format(-$this->getDiferencia(), 0, ',', '.');
        }

        return number_format($this->getDiferencia(), 0, ',', '.');
    }

    public function addPagoAmount($amount)
    {
        $this->setPago($this->getPago() + $amount);
    }

    public function removePagoAmount($amount)
    {
        $this->setPago($this->getPago() - $amount);
    }
}
