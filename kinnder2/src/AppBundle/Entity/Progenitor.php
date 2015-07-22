<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Progenitor
 *
 * @ORM\Table(name="progenitor")
 * @ORM\Entity
 */
class Progenitor extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
     * @ORM\ManyToMany(targetEntity="Estudiante", inversedBy="progenitores")
     * @ORM\JoinTable(name="usuario_progenitor",
     *      joinColumns={@ORM\JoinColumn(name="progenitor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")}
     *      )
     **/    
    private $estudiantes;    

    /**
     * @ORM\ManyToMany(targetEntity="Role", indexBy="name")
     * @ORM\JoinTable(name="maith_bunny_users_roles")
     */
    protected $user_roles;

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
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->cuentas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->estudiantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user_roles = new ArrayCollection();
    }

    /**
     * Add estudiantes
     *
     * @param \AppBundle\Entity\Estudiante $estudiantes
     * @return Progenitor
     */
    public function addEstudiante(\AppBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes[] = $estudiantes;

        return $this;
    }

    /**
     * Remove estudiantes
     *
     * @param \AppBundle\Entity\Estudiante $estudiantes
     */
    public function removeEstudiante(\AppBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes->removeElement($estudiantes);
    }

    /**
     * Get estudiantes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEstudiantes()
    {
        return $this->estudiantes;
    }

 /**
     * Returns an ARRAY of Role objects with the default Role object appended.
     * @return array
     */
    public function getRoles() {
        return array_merge($this->user_roles->toArray(), array(new Role(array(parent::ROLE_DEFAULT))));
    }
 
    /**
     * Returns the true ArrayCollection of Roles.
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getRolesCollection() {
        return $this->user_roles;
    }
 
    /**
     * Pass a string, get the desired Role object or null.
     * @param string $role
     * @return Role|null
     */
    public function getRole($role) {
        foreach ($this->getRoles() as $roleItem) {
            if ($role == $roleItem->getRole()) {
                return $roleItem;
            }
        }
        return null;
    }
 
    /**
     * Pass a string, checks if we have that Role. Same functionality as getRole() except returns a real boolean.
     * @param string $role
     * @return boolean
     */
    public function hasRole($role) {
        if ($this->getRole($role)) {
            return true;
        }
        return false;
    }
 
    /**
     * Adds a Role OBJECT to the ArrayCollection. Can't type hint due to interface so throws Exception.
     * @throws Exception
     * @param Role $role
     */
    public function addRole($role) {
        if (!$role instanceof Role) {
            throw new \Exception("addRole takes a Role object as the parameter");
        }
        if (!$this->hasRole($role->getRole())) {
            $this->user_roles->add($role);
        }
    }
 
    /**
     * Pass a string, remove the Role object from collection.
     * @param string $role
     */
    public function removeRole($role) {
        $roleElement = $this->getRole($role);
        if ($roleElement) {
            $this->user_roles->removeElement($roleElement);
        }
    }
 
    /**
     * Pass an ARRAY of Role objects and will clear the collection and re-set it with new Roles.
     * Type hinted array due to interface.
     * @param array $roles Of Role objects.
     */
    public function setRoles(array $roles) {
        $this->user_roles->clear();
        foreach ($roles as $role) {
            $this->addRole($role);
        }
    }
 
    /**
     * Directly set the ArrayCollection of Roles. Type hinted as Collection which is the parent of (Array|Persistent)Collection.
     * @param Doctrine\Common\Collections\Collection $role
     */
    public function setRolesCollection(Collection $collection) {
        $this->user_roles = $collection;
    }    
}
