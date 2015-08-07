<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estudiante
 *
 * @ORM\Table(name="estudiante")
 * @ORM\Entity
* @ORM\Entity(repositoryClass="AppBundle\Entity\EstudianteRepository")
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
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var integer
     *
     * @ORM\Column(name="anio_ingreso", type="bigint", nullable=true)
     */
    private $anioIngreso;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="SociedadMedica", inversedBy="estudiantes")
     * @ORM\JoinColumn(name="sociedad_medica_id", referencedColumnName="id", nullable=true)
     * 
     **/ 
    private $sociedadMedica;

    /**
     * @var string
     *
     * @ORM\Column(name="referencia_bancaria", type="string", length=64, nullable=false)
     */
    private $referenciaBancaria;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="EmergenciaMedica", inversedBy="estudiantes")
     * @ORM\JoinColumn(name="emergencia_medica_id", referencedColumnName="id", nullable=true)
     * 
     **/     
    private $emergenciaMedica;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Horario", inversedBy="estudiantes")
     * @ORM\JoinColumn(name="horario_id", referencedColumnName="id", nullable=true)
     * 
     **/     
    private $horario;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Colegio", inversedBy="estudiantes")
     * @ORM\JoinColumn(name="futuro_colegio_id", referencedColumnName="id", nullable=true)
     * 
     **/     
    private $futuroColegio;

    /**
     * @var integer
     *
     * @ORM\Column(name="descuento", type="bigint", nullable=true)
     */
    private $descuento;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Clase", inversedBy="estudiantes")
     * @ORM\JoinColumn(name="clase_id", referencedColumnName="id", nullable=true)
     * 
     **/    
    private $clase;

    /**
     * @var boolean
     *
     * @ORM\Column(name="egresado", type="boolean", nullable=true, options={"default": 0})
     */
    private $egresado;


    /**
     * @ORM\ManyToMany(targetEntity="Actividad", inversedBy="estudiantes")
     * @ORM\JoinTable(name="estudiante_actividad",
     *      joinColumns={@ORM\JoinColumn(name="estudiante_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="actividad_id", referencedColumnName="id")}
     *      )
     **/    
    private $actividades;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Cuenta", inversedBy="estudiantes")
     * @ORM\JoinColumn(name="cuenta_id", referencedColumnName="id", nullable=true)
     * 
     **/      
    private $cuenta;    
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="FacturaEstudiante", mappedBy="estudiante")
     *
     */
    private $facturas;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Estudiante", mappedBy="myBrothers")
     **/
    private $brothersWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="Estudiante", inversedBy="brothersWithMe")
     * @ORM\JoinTable(name="estudiante_hermano",
     *      joinColumns={@ORM\JoinColumn(name="estudiante_from", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="estudiante_to", referencedColumnName="id")}
     *      )
     **/
    private $myBrothers;
    
    
    /**
     * @ORM\ManyToMany(targetEntity="Progenitor", mappedBy="estudiantes")
     * 
     * */    
    private $progenitores;

    /**
     * Set id
     *
     * @return integer 
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @param \AppBundle\Entity\FacturaEstudiante $facturas
     * @return Estudiante
     */
    public function addFactura(\AppBundle\Entity\FacturaEstudiante $facturas)
    {
        $this->facturas[] = $facturas;

        return $this;
    }

    /**
     * Remove facturas
     *
     * @param \AppBundle\Entity\FacturaEstudiante $facturas
     */
    public function removeFactura(\AppBundle\Entity\FacturaEstudiante $facturas)
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
        $this->facturas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->brothersWithMe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->myBrothers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->progenitores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->anioIngreso = date('Y');
    }


    /**
     * Add actividades
     *
     * @param \AppBundle\Entity\Actividad $actividades
     * @return Estudiante
     */
    public function addActividade(\AppBundle\Entity\Actividad $actividades)
    {
        $this->actividades[] = $actividades;

        return $this;
    }

    /**
     * Remove actividades
     *
     * @param \AppBundle\Entity\Actividad $actividades
     */
    public function removeActividade(\AppBundle\Entity\Actividad $actividades)
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
    
    public function __toString(){
      return $this->getNombre();
    }

    /**
     * Set horario
     *
     * @param \AppBundle\Entity\Horario $horario
     * @return Estudiante
     */
    public function setHorario(\AppBundle\Entity\Horario $horario = null)
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * Get horario
     *
     * @return \AppBundle\Entity\Horario 
     */
    public function getHorario()
    {
        return $this->horario;
    }

    /**
     * Set clase
     *
     * @param \AppBundle\Entity\Clase $clase
     * @return Estudiante
     */
    public function setClase(\AppBundle\Entity\Clase $clase = null)
    {
        $this->clase = $clase;

        return $this;
    }

    /**
     * Get clase
     *
     * @return \AppBundle\Entity\Clase 
     */
    public function getClase()
    {
        return $this->clase;
    }

    /**
     * Set cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     * @return Estudiante
     */
    public function setCuenta(\AppBundle\Entity\Cuenta $cuenta)
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
     * Set futuroColegio
     *
     * @param \AppBundle\Entity\Colegio $futuroColegio
     * @return Estudiante
     */
    public function setFuturoColegio(\AppBundle\Entity\Colegio $futuroColegio = null)
    {
        $this->futuroColegio = $futuroColegio;

        return $this;
    }

    /**
     * Get futuroColegio
     *
     * @return \AppBundle\Entity\Colegio 
     */
    public function getFuturoColegio()
    {
        return $this->futuroColegio;
    }

    /**
     * Set sociedadMedica
     *
     * @param \AppBundle\Entity\SociedadMedica $sociedadMedica
     * @return Estudiante
     */
    public function setSociedadMedica(\AppBundle\Entity\SociedadMedica $sociedadMedica = null)
    {
        $this->sociedadMedica = $sociedadMedica;

        return $this;
    }

    /**
     * Get sociedadMedica
     *
     * @return \AppBundle\Entity\SociedadMedica 
     */
    public function getSociedadMedica()
    {
        return $this->sociedadMedica;
    }

    /**
     * Set emergenciaMedica
     *
     * @param \AppBundle\Entity\EmergenciaMedica $emergenciaMedica
     * @return Estudiante
     */
    public function setEmergenciaMedica(\AppBundle\Entity\EmergenciaMedica $emergenciaMedica = null)
    {
        $this->emergenciaMedica = $emergenciaMedica;

        return $this;
    }

    /**
     * Get emergenciaMedica
     *
     * @return \AppBundle\Entity\EmergenciaMedica 
     */
    public function getEmergenciaMedica()
    {
        return $this->emergenciaMedica;
    }
}
