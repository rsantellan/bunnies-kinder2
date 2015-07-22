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
    private $role;
 
    /**
     * @ORM\ManyToMany(targetEntity="Progenitor", mappedBy="roles")
     */
    private $users;
 
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
 
    public function getId()
    {
        return $this->id;
    }
 
    public function setName($name)
    {
        $this->role = $name;
 
        return $this;
    }
 
    public function getName()
    {
        return $this->role;
    }
 
    public function addUser(User $user)
    {
        $user->addRole($this);
        $this->users->add($user);
 
        return $this;
    }
 
    public function removeUser(User $user)
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
}