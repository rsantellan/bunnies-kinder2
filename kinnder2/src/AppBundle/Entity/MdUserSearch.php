<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdUserSearch
 *
 * @ORM\Table(name="md_user_search", indexes={@ORM\Index(name="username_index_idx", columns={"username"}), @ORM\Index(name="email_index_idx", columns={"email"}), @ORM\Index(name="last_name_index_idx", columns={"last_name"}), @ORM\Index(name="name_index_idx", columns={"name"}), @ORM\Index(name="md_user_id_idx", columns={"md_user_id"})})
 * @ORM\Entity
 */
class MdUserSearch
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="md_user_id", type="integer", nullable=false)
     */
    private $mdUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=128, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=128, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=2, nullable=true)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar_src", type="text", nullable=true)
     */
    private $avatarSrc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true, options={"default": 0})
     */
    private $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="blocked", type="boolean", nullable=true, options={"default": 0})
     */
    private $blocked;

    /**
     * @var boolean
     *
     * @ORM\Column(name="admin", type="boolean", nullable=true, options={"default": 0})
     */
    private $admin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_email", type="boolean", nullable=true, options={"default": 0})
     */
    private $showEmail;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mdUserId
     *
     * @param integer $mdUserId
     * @return MdUserSearch
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
     * Set email
     *
     * @param string $email
     * @return MdUserSearch
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return MdUserSearch
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return MdUserSearch
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return MdUserSearch
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     * @return MdUserSearch
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string 
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set avatarSrc
     *
     * @param string $avatarSrc
     * @return MdUserSearch
     */
    public function setAvatarSrc($avatarSrc)
    {
        $this->avatarSrc = $avatarSrc;

        return $this;
    }

    /**
     * Get avatarSrc
     *
     * @return string 
     */
    public function getAvatarSrc()
    {
        return $this->avatarSrc;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return MdUserSearch
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set blocked
     *
     * @param boolean $blocked
     * @return MdUserSearch
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;

        return $this;
    }

    /**
     * Get blocked
     *
     * @return boolean 
     */
    public function getBlocked()
    {
        return $this->blocked;
    }

    /**
     * Set admin
     *
     * @param boolean $admin
     * @return MdUserSearch
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean 
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * Set showEmail
     *
     * @param boolean $showEmail
     * @return MdUserSearch
     */
    public function setShowEmail($showEmail)
    {
        $this->showEmail = $showEmail;

        return $this;
    }

    /**
     * Get showEmail
     *
     * @return boolean 
     */
    public function getShowEmail()
    {
        return $this->showEmail;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MdUserSearch
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
     * @return MdUserSearch
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
}
