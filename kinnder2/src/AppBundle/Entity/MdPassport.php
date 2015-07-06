<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdPassport
 *
 * @ORM\Table(name="md_passport", indexes={@ORM\Index(name="md_user_id_idx", columns={"md_user_id"})})
 * @ORM\Entity
 */
class MdPassport
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
     * @var integer
     *
     * @ORM\Column(name="md_user_id", type="integer", nullable=false)
     */
    private $mdUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=128, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=128, nullable=false)
     */
    private $password;

    /**
     * @var boolean
     *
     * @ORM\Column(name="account_active", type="boolean", nullable=false)
     */
    private $accountActive;

    /**
     * @var boolean
     *
     * @ORM\Column(name="account_blocked", type="boolean", nullable=false)
     */
    private $accountBlocked;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

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
     * @return MdPassport
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
     * Set username
     *
     * @param string $username
     * @return MdPassport
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
     * Set password
     *
     * @param string $password
     * @return MdPassport
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set accountActive
     *
     * @param boolean $accountActive
     * @return MdPassport
     */
    public function setAccountActive($accountActive)
    {
        $this->accountActive = $accountActive;

        return $this;
    }

    /**
     * Get accountActive
     *
     * @return boolean 
     */
    public function getAccountActive()
    {
        return $this->accountActive;
    }

    /**
     * Set accountBlocked
     *
     * @param boolean $accountBlocked
     * @return MdPassport
     */
    public function setAccountBlocked($accountBlocked)
    {
        $this->accountBlocked = $accountBlocked;

        return $this;
    }

    /**
     * Get accountBlocked
     *
     * @return boolean 
     */
    public function getAccountBlocked()
    {
        return $this->accountBlocked;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return MdPassport
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime 
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MdPassport
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
     * @return MdPassport
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
