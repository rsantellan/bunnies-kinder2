<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Progenitor
 *
 * @ORM\Table(name="progenitor", uniqueConstraints={@ORM\UniqueConstraint(name="mail_index_idx", columns={"mail"})}, indexes={@ORM\Index(name="md_user_id_idx", columns={"md_user_id"})})
 * @ORM\Entity
 */
class Progenitor
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
     * @ORM\Column(name="nombre", type="string", length=64, nullable=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=128, nullable=true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=128, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=64, nullable=true)
     */
    private $celular;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=64, nullable=true)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="clave", type="string", length=64, nullable=true)
     */
    private $clave;

    /**
     * @var integer
     *
     * @ORM\Column(name="md_user_id", type="integer", nullable=true)
     */
    private $mdUserId;



    /**
     * @ORM\ManyToMany(targetEntity="Cuenta", inversedBy="progenitores")
     * @ORM\JoinTable(name="cuentapadre")
     **/    
    private $cuentas;
    
    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="progenitores")
     * @ORM\JoinTable(name="usuario_progenitor")
     **/    
    private $alumnos;    

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
     * @return Progenitor
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
     * Set direccion
     *
     * @param string $direccion
     * @return Progenitor
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Progenitor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Progenitor
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set mail
     *
     * @param string $mail
     * @return Progenitor
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set clave
     *
     * @param string $clave
     * @return Progenitor
     */
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }

    /**
     * Get clave
     *
     * @return string 
     */
    public function getClave()
    {
        return $this->clave;
    }

    /**
     * Set mdUserId
     *
     * @param integer $mdUserId
     * @return Progenitor
     */
    public function setMdUserId($mdUserId)
    {
        $this->mdUserId = $mdUserId;

        return $this;
    }

    /**
     * Get mdUserId
     *
     * @return integer 
     */
    public function getMdUserId()
    {
        return $this->mdUserId;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cuentas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cuentas
     *
     * @param \AppBundle\Entity\Cuenta $cuentas
     * @return Progenitor
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
     * Add alumnos
     *
     * @param \AppBundle\Entity\Usuario $alumnos
     * @return Progenitor
     */
    public function addAlumno(\AppBundle\Entity\Usuario $alumnos)
    {
        $this->alumnos[] = $alumnos;

        return $this;
    }

    /**
     * Remove alumnos
     *
     * @param \AppBundle\Entity\Usuario $alumnos
     */
    public function removeAlumno(\AppBundle\Entity\Usuario $alumnos)
    {
        $this->alumnos->removeElement($alumnos);
    }

    /**
     * Get alumnos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlumnos()
    {
        return $this->alumnos;
    }
}
