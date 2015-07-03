<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdPassportRememberKey
 *
 * @ORM\Table(name="md_passport_remember_key", indexes={@ORM\Index(name="md_passport_id_idx", columns={"md_passport_id"})})
 * @ORM\Entity
 */
class MdPassportRememberKey
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=50)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $ipAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="md_passport_id", type="integer", nullable=true)
     */
    private $mdPassportId;

    /**
     * @var string
     *
     * @ORM\Column(name="remember_key", type="string", length=32, nullable=true)
     */
    private $rememberKey;

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
     * Set id
     *
     * @param integer $id
     * @return MdPassportRememberKey
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
     * Set ipAddress
     *
     * @param string $ipAddress
     * @return MdPassportRememberKey
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string 
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set mdPassportId
     *
     * @param integer $mdPassportId
     * @return MdPassportRememberKey
     */
    public function setMdPassportId($mdPassportId)
    {
        $this->mdPassportId = $mdPassportId;

        return $this;
    }

    /**
     * Get mdPassportId
     *
     * @return integer 
     */
    public function getMdPassportId()
    {
        return $this->mdPassportId;
    }

    /**
     * Set rememberKey
     *
     * @param string $rememberKey
     * @return MdPassportRememberKey
     */
    public function setRememberKey($rememberKey)
    {
        $this->rememberKey = $rememberKey;

        return $this;
    }

    /**
     * Get rememberKey
     *
     * @return string 
     */
    public function getRememberKey()
    {
        return $this->rememberKey;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MdPassportRememberKey
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
     * @return MdPassportRememberKey
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
