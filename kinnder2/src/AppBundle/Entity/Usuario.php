<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="billetera_id_idx", columns={"billetera_id"})})
 * @ORM\Entity
 */
class Usuario
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
     * @ORM\Column(name="nombre", type="string", length=64, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=64, nullable=false)
     */
    private $apellido;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="datetime", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio_ingreso", type="bigint", nullable=true)
     */
    private $anioIngreso;

    /**
     * @var string
     *
     * @ORM\Column(name="sociedad", type="string", length=64, nullable=true)
     */
    private $sociedad;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia_bancaria", type="string", length=64, nullable=false)
     */
    private $referenciaBancaria;

    /**
     * @var string
     *
     * @ORM\Column(name="emergencia_medica", type="string", length=64, nullable=true)
     */
    private $emergenciaMedica;

    /**
     * @var string
     *
     * @ORM\Column(name="horario", type="string", nullable=true)
     */
    private $horario;

    /**
     * @var string
     *
     * @ORM\Column(name="futuro_colegio", type="string", length=64, nullable=true)
     */
    private $futuroColegio;

    /**
     * @var integer
     *
     * @ORM\Column(name="descuento", type="bigint", nullable=true)
     */
    private $descuento;

    /**
     * @var string
     *
     * @ORM\Column(name="clase", type="string", nullable=true)
     */
    private $clase;

    /**
     * @var boolean
     *
     * @ORM\Column(name="egresado", type="boolean", nullable=true)
     */
    private $egresado;

    /**
     * @var integer
     *
     * @ORM\Column(name="billetera_id", type="integer", nullable=true)
     */
    private $billeteraId;

    /**
     * @ORM\ManyToMany(targetEntity="Actividades", inversedBy="usuarios")
     * @ORM\JoinTable(name="usuario_actividades")
     **/    
    private $actividades;

    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Billetera", inversedBy="usuarios")
     * @ORM\JoinColumn(name="billetera_id", referencedColumnName="id")
     * 
     **/
    private $billetera;
    
    /**
     * @ORM\ManyToMany(targetEntity="Cuenta", inversedBy="usuarios")
     * @ORM\JoinTable(name="cuentausuario")
     **/    
    private $cuentas;    
    
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Exoneracion", mappedBy="usuario")
     *
     */
    private $exoneraciones;
    
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
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     * @return Usuario
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Usuario
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set anioIngreso
     *
     * @param integer $anioIngreso
     * @return Usuario
     */
    public function setAnioIngreso($anioIngreso)
    {
        $this->anioIngreso = $anioIngreso;

        return $this;
    }

    /**
     * Get anioIngreso
     *
     * @return integer 
     */
    public function getAnioIngreso()
    {
        return $this->anioIngreso;
    }

    /**
     * Set sociedad
     *
     * @param string $sociedad
     * @return Usuario
     */
    public function setSociedad($sociedad)
    {
        $this->sociedad = $sociedad;

        return $this;
    }

    /**
     * Get sociedad
     *
     * @return string 
     */
    public function getSociedad()
    {
        return $this->sociedad;
    }

    /**
     * Set referenciaBancaria
     *
     * @param string $referenciaBancaria
     * @return Usuario
     */
    public function setReferenciaBancaria($referenciaBancaria)
    {
        $this->referenciaBancaria = $referenciaBancaria;

        return $this;
    }

    /**
     * Get referenciaBancaria
     *
     * @return string 
     */
    public function getReferenciaBancaria()
    {
        return $this->referenciaBancaria;
    }

    /**
     * Set emergenciaMedica
     *
     * @param string $emergenciaMedica
     * @return Usuario
     */
    public function setEmergenciaMedica($emergenciaMedica)
    {
        $this->emergenciaMedica = $emergenciaMedica;

        return $this;
    }

    /**
     * Get emergenciaMedica
     *
     * @return string 
     */
    public function getEmergenciaMedica()
    {
        return $this->emergenciaMedica;
    }

    /**
     * Set horario
     *
     * @param string $horario
     * @return Usuario
     */
    public function setHorario($horario)
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * Get horario
     *
     * @return string 
     */
    public function getHorario()
    {
        return $this->horario;
    }

    /**
     * Set futuroColegio
     *
     * @param string $futuroColegio
     * @return Usuario
     */
    public function setFuturoColegio($futuroColegio)
    {
        $this->futuroColegio = $futuroColegio;

        return $this;
    }

    /**
     * Get futuroColegio
     *
     * @return string 
     */
    public function getFuturoColegio()
    {
        return $this->futuroColegio;
    }

    /**
     * Set descuento
     *
     * @param integer $descuento
     * @return Usuario
     */
    public function setDescuento($descuento)
    {
        $this->descuento = $descuento;

        return $this;
    }

    /**
     * Get descuento
     *
     * @return integer 
     */
    public function getDescuento()
    {
        return $this->descuento;
    }

    /**
     * Set clase
     *
     * @param string $clase
     * @return Usuario
     */
    public function setClase($clase)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return string 
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set egresado
     *
     * @param boolean $egresado
     * @return Usuario
     */
    public function setEgresado($egresado)
    {
        $this->egresado = $egresado;

        return $this;
    }

    /**
     * Get egresado
     *
     * @return boolean 
     */
    public function getEgresado()
    {
        return $this->egresado;
    }

    /**
     * Set billeteraId
     *
     * @param integer $billeteraId
     * @return Usuario
     */
    public function setBilleteraId($billeteraId)
    {
        $this->billeteraId = $billeteraId;

        return $this;
    }

    /**
     * Get billeteraId
     *
     * @return integer 
     */
    public function getBilleteraId()
    {
        return $this->billeteraId;
    }
    

    /**
     * Add actividades
     *
     * @param \AppBundle\Entity\Actividades $actividades
     * @return Usuario
     */
    public function addActividade(\AppBundle\Entity\Actividades $actividades)
    {
        $this->actividades[] = $actividades;

        return $this;
    }

    /**
     * Remove actividades
     *
     * @param \AppBundle\Entity\Actividades $actividades
     */
    public function removeActividade(\AppBundle\Entity\Actividades $actividades)
    {
        $this->actividades->removeElement($actividades);
    }

    /**
     * Get actividades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActividades()
    {
        return $this->actividades;
    }

    /**
     * Set billetera
     *
     * @param \AppBundle\Entity\Billetera $billetera
     * @return Usuario
     */
    public function setBilletera(\AppBundle\Entity\Billetera $billetera = null)
    {
        $this->billetera = $billetera;

        return $this;
    }

    /**
     * Get billetera
     *
     * @return \AppBundle\Entity\Billetera 
     */
    public function getBilletera()
    {
        return $this->billetera;
    }

    /**
     * Add cuentas
     *
     * @param \AppBundle\Entity\Cuenta $cuentas
     * @return Usuario
     */
    public function addCuenta(\AppBundle\Entity\Cuenta $cuentas)
    {
        $this->cuentas[] = $cuentas;

        return $this;
    }

    /**
     * Remove cuentas
     *
     * @param \AppBundle\Entity\Cuenta $cuentas
     */
    public function removeCuenta(\AppBundle\Entity\Cuenta $cuentas)
    {
        $this->cuentas->removeElement($cuentas);
    }

    /**
     * Get cuentas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCuentas()
    {
        return $this->cuentas;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cuentas = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Add exoneracion
     *
     * @param \AppBundle\Entity\Exoneracion $exoneracion
     * @return Usuario
     */
    public function addExoneracion(\AppBundle\Entity\Exoneracion $exoneracion)
    {
        $this->exoneracion[] = $exoneracion;

        return $this;
    }

    /**
     * Remove exoneracion
     *
     * @param \AppBundle\Entity\Exoneracion $exoneracion
     */
    public function removeExoneracion(\AppBundle\Entity\Exoneracion $exoneracion)
    {
        $this->exoneracion->removeElement($exoneracion);
    }

    /**
     * Get exoneracion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExoneracion()
    {
        return $this->exoneracion;
    }

    /**
     * Add exoneraciones
     *
     * @param \AppBundle\Entity\Exoneracion $exoneraciones
     * @return Usuario
     */
    public function addExoneracione(\AppBundle\Entity\Exoneracion $exoneraciones)
    {
        $this->exoneraciones[] = $exoneraciones;

        return $this;
    }

    /**
     * Remove exoneraciones
     *
     * @param \AppBundle\Entity\Exoneracion $exoneraciones
     */
    public function removeExoneracione(\AppBundle\Entity\Exoneracion $exoneraciones)
    {
        $this->exoneraciones->removeElement($exoneraciones);
    }

    /**
     * Get exoneraciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExoneraciones()
    {
        return $this->exoneraciones;
    }
}
