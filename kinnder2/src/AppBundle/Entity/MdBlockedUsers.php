<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdBlockedUsers
 *
 * @ORM\Table(name="md_blocked_users")
 * @ORM\Entity
 */
class MdBlockedUsers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="md_user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $mdUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="reason", type="string", length=128, nullable=true)
     */
    private $reason;

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
     * Get mdUserId
     *
     * @return integer 
     */
    public function getMdUserId()
    {
        return $this->mdUserId;
    }

    /**
     * Set reason
     *
     * @param string $reason
     * @return MdBlockedUsers
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string 
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MdBlockedUsers
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
     * @return MdBlockedUsers
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

    /**
     * Set mdUserId
     *
     * @param integer $mdUserId
     * @return MdBlockedUsers
     */
    public function setMdUserId($mdUserId)
    {
        $this->mdUserId = $mdUserId;

        return $this;
    }
}
