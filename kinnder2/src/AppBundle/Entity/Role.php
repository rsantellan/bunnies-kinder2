<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Role
 * @ORM\Entity
 * @ORM\Table(name="maith_bunny_role")
 */
class Role implements RoleInterface {
 
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
     * @ORM\Column(name="role", type="string", unique=true, length=70)
     */
    private $name;
 
    /**
     * @ORM\ManyToMany(targetEntity="Progenitor", mappedBy="user_roles")
     */
    private $users;
 
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
 
    public function getId()
    {
        return $this->id;
    }
 
    public function setName($name)
    {
        $this->name = $name;
 
        return $this;
    }
 
    public function getName()
    {
        return $this->name;
    }
 
    public function addUser(Progenitor $user)
    {
        $user->addRole($this);
        $this->users->add($user);
 
        return $this;
    }
 
    public function removeUser(Progenitor $user)
    {
        $user->removeRole($this);
        $this->users->removeElement($user);
    }
 
    public function getUsers()
    {
        return $this->users;
    }
 
    function __toString()
    {
        return $this->getName();
    }
 
    public function getRole(){
        return $this->getName();
    }

    /**
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }
}
