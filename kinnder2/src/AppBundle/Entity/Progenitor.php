<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Progenitor.
 *
 * @ORM\Table(name="progenitor")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProgenitorRepository")
 */
class Progenitor extends BaseUser
{
    /**
     * @var int
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
     * @var int
     *
     * @ORM\Column(name="old_id", type="integer", nullable=true)
     */
    private $oldId;

    /**
     * @ORM\ManyToOne(targetEntity="Cuenta", inversedBy="progenitores")
     * @ORM\JoinColumn(name="cuenta_id", referencedColumnName="id", nullable=true)
     **/
    private $cuenta;

    /**
     * @ORM\ManyToMany(targetEntity="Estudiante", inversedBy="progenitores")
     * @ORM\JoinTable(name="estudiante_progenitor",
     *      joinColumns={@ORM\JoinColumn(name="progenitor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="estudiante_id", referencedColumnName="id")}
     *      )
     **/
    private $estudiantes;

    /**
     * @ORM\ManyToMany(targetEntity="Role", indexBy="name", inversedBy="users")
     * @ORM\JoinTable(name="maith_bunny_users_roles")
     */
    protected $user_roles;

    /**
     * @ORM\OneToOne(targetEntity="\Maith\NewsletterBundle\Entity\User",cascade={"persist"})
     * @ORM\JoinColumn(name="news_letter_user_id", referencedColumnName="id")
     */
    private $newsletterUser;

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
     * Set nombre.
     *
     * @param string $nombre
     *
     * @return Progenitor
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set direccion.
     *
     * @param string $direccion
     *
     * @return Progenitor
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion.
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set telefono.
     *
     * @param string $telefono
     *
     * @return Progenitor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono.
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular.
     *
     * @param string $celular
     *
     * @return Progenitor
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular.
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->estudiantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->user_roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add estudiantes.
     *
     * @param \AppBundle\Entity\Estudiante $estudiantes
     *
     * @return Progenitor
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
     * Returns an ARRAY of Role objects with the default Role object appended.
     *
     * @return array
     */
    public function getRoles()
    {
        $user_roles = array();
        if ($this->user_roles) {
            $user_roles = $this->user_roles->toArray();
        }

        return $user_roles;
    }

    /**
     * Returns the true ArrayCollection of Roles.
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getRolesCollection()
    {
        return $this->user_roles;
    }

    /**
     * Pass a string, get the desired Role object or null.
     *
     * @param string $role
     *
     * @return Role|null
     */
    public function getRole($role)
    {
        foreach ($this->getRoles() as $roleItem) {
            if ($role == $roleItem->getRole()) {
                return $roleItem;
            }
        }

        return;
    }

    /**
     * Pass a string, checks if we have that Role. Same functionality as getRole() except returns a real boolean.
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->getRole($role)) {
            return true;
        }

        return false;
    }

    /**
     * Adds a Role OBJECT to the ArrayCollection. Can't type hint due to interface so throws Exception.
     *
     * @throws Exception
     *
     * @param Role $role
     */
    public function addRole($role)
    {
        if (is_string($role)) {
            parent::addRole($role);
        } else {
            if ($role instanceof Role) {
                if (!$this->hasRole($role->getRole())) {
                    $this->user_roles->add($role);
                }
            } else {
                throw new \Exception(sprintf('addRole takes a Role object as the parameter. %s given', get_class($role)));
            }
        }
    }

    /**
     * Pass a string, remove the Role object from collection.
     *
     * @param string $role
     */
    public function removeRole($role)
    {
        $roleElement = $this->getRole($role);
        if ($roleElement) {
            $this->user_roles->removeElement($roleElement);
        }
    }

    /**
     * Pass an ARRAY of Role objects and will clear the collection and re-set it with new Roles.
     * Type hinted array due to interface.
     *
     * @param array $roles Of Role objects.
     */
    public function setRoles(array $roles)
    {
        $this->user_roles->clear();
        $parentRoles = array();
        foreach ($roles as $role) {
            $this->addRole($role);
            $parentRoles[] = $role->getName();
        }
        parent::setRoles($parentRoles);
    }

    /**
     * Directly set the ArrayCollection of Roles. Type hinted as Collection which is the parent of (Array|Persistent)Collection.
     *
     * @param Doctrine\Common\Collections\Collection $role
     */
    public function setRolesCollection(\Doctrine\Common\Collections\Collection $collection)
    {
        $this->user_roles = $collection;
    }

    /**
     * Add user_roles.
     *
     * @param \AppBundle\Entity\Role $userRoles
     *
     * @return Progenitor
     */
    public function addUserRole(\AppBundle\Entity\Role $userRoles)
    {
        $this->user_roles[] = $userRoles;

        return $this;
    }

    /**
     * Remove user_roles.
     *
     * @param \AppBundle\Entity\Role $userRoles
     */
    public function removeUserRole(\AppBundle\Entity\Role $userRoles)
    {
        $this->user_roles->removeElement($userRoles);
    }

    /**
     * Get user_roles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserRoles()
    {
        return $this->user_roles;
    }

    /**
     * Set newsletterUser.
     *
     * @param \Maith\NewsletterBundle\Entity\User $newsletterUser
     *
     * @return Progenitor
     */
    public function setNewsletterUser(\Maith\NewsletterBundle\Entity\User $newsletterUser = null)
    {
        $this->newsletterUser = $newsletterUser;

        return $this;
    }

    /**
     * Get newsletterUser.
     *
     * @return \Maith\NewsletterBundle\Entity\User
     */
    public function getNewsletterUser()
    {
        return $this->newsletterUser;
    }

    /**
     * Set cuenta.
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     *
     * @return Progenitor
     */
    public function setCuenta(\AppBundle\Entity\Cuenta $cuenta)
    {
        $this->cuenta = $cuenta;

        return $this;
    }

    /**
     * Get cuenta.
     *
     * @return \AppBundle\Entity\Cuenta
     */
    public function getCuenta()
    {
        return $this->cuenta;
    }

    /**
     * Set oldId.
     *
     * @param int $oldId
     *
     * @return Progenitor
     */
    public function setOldId($oldId)
    {
        $this->oldId = $oldId;

        return $this;
    }

    /**
     * Get oldId.
     *
     * @return int
     */
    public function getOldId()
    {
        return $this->oldId;
    }
}
