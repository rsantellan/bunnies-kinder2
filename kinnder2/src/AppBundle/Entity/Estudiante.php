<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estudiante
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="billetera_id_idx", columns={"billetera_id"})})
 * @ORM\Entity
 */
class Estudiante
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @ORM\ManyToMany(targetEntity="Actividad", inversedBy="estudiantes")
     * @ORM\JoinTable(name="usuario_actividades",
     *      joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="actividad_id", referencedColumnName="id")}
     *      )
     **/    
    private $actividades;

    /**
     * @ORM\ManyToMany(targetEntity="Cuenta", inversedBy="estudiantes")
     * @ORM\JoinTable(name="cuentausuario",
     *      joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="cuenta_id", referencedColumnName="id")}
     *      )
     **/    
    private $cuentas;    
    
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Pagos", mappedBy="estudiante")
     *
     */
    private $pagos;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Facturausuario", mappedBy="estudiante")
     *
     */
    private $facturas;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Estudiante", mappedBy="myBrothers")
     **/
    private $brothersWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="Estudiante", inversedBy="brothersWithMe")
     * @ORM\JoinTable(name="hermanos",
     *      joinColumns={@ORM\JoinColumn(name="usuario_from", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="usuario_to", referencedColumnName="id")}
     *      )
     **/
    private $myBrothers;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Progenitor", mappedBy="estudiantes")
     * 
     * */    
    private $progenitores;
    
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * @return Estudiante
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
     * Add actividades
     *
     * @param \AppBundle\Entity\Actividades $actividades
     * @return Estudiante
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
     * Add cuentas
     *
     * @param \AppBundle\Entity\Cuenta $cuentas
     * @return Estudiante
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
     * Add exoneracion
     *
     * @param \AppBundle\Entity\Exoneracion $exoneracion
     * @return Estudiante
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
     * Add facturas
     *
     * @param \AppBundle\Entity\Facturausuario $facturas
     * @return Estudiante
     */
    public function addFactura(\AppBundle\Entity\Facturausuario $facturas)
    {
        $this->facturas[] = $facturas;

        return $this;
    }

    /**
     * Remove facturas
     *
     * @param \AppBundle\Entity\Facturausuario $facturas
     */
    public function removeFactura(\AppBundle\Entity\Facturausuario $facturas)
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

    /**
     * Add pagos
     *
     * @param \AppBundle\Entity\Pagos $pagos
     * @return Estudiante
     */
    public function addPago(\AppBundle\Entity\Pagos $pagos)
    {
        $this->pagos[] = $pagos;

        return $this;
    }

    /**
     * Remove pagos
     *
     * @param \AppBundle\Entity\Pagos $pagos
     */
    public function removePago(\AppBundle\Entity\Pagos $pagos)
    {
        $this->pagos->removeElement($pagos);
    }

    /**
     * Get pagos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPagos()
    {
        return $this->pagos;
    }

    /**
     * Add brothersWithMe
     *
     * @param \AppBundle\Entity\Estudiante $brothersWithMe
     * @return Estudiante
     */
    public function addBrothersWithMe(\AppBundle\Entity\Estudiante $brothersWithMe)
    {
        $this->brothersWithMe[] = $brothersWithMe;

        return $this;
    }

    /**
     * Remove brothersWithMe
     *
     * @param \AppBundle\Entity\Estudiante $brothersWithMe
     */
    public function removeBrothersWithMe(\AppBundle\Entity\Estudiante $brothersWithMe)
    {
        $this->brothersWithMe->removeElement($brothersWithMe);
    }

    /**
     * Get brothersWithMe
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBrothersWithMe()
    {
        return $this->brothersWithMe;
    }

    /**
     * Add myBrothers
     *
     * @param \AppBundle\Entity\Estudiante $myBrothers
     * @return Estudiante
     */
    public function addMyBrother(\AppBundle\Entity\Estudiante $myBrothers)
    {
        $this->myBrothers[] = $myBrothers;

        return $this;
    }

    /**
     * Remove myBrothers
     *
     * @param \AppBundle\Entity\Estudiante $myBrothers
     */
    public function removeMyBrother(\AppBundle\Entity\Estudiante $myBrothers)
    {
        $this->myBrothers->removeElement($myBrothers);
    }

    /**
     * Get myBrothers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMyBrothers()
    {
        return $this->myBrothers;
    }

    /**
     * Add progenitores
     *
     * @param \AppBundle\Entity\Progenitor $progenitores
     * @return Estudiante
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
     * Constructor
     */
    public function __construct()
    {
        $this->actividades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cuentas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->pagos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->facturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->brothersWithMe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->myBrothers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->progenitores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set billeteraId
     *
     * @param integer $billeteraId
     * @return Estudiante
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
}
