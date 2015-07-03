<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdNewsLetterGroupUser
 *
 * @ORM\Table(name="md_news_letter_group_user", indexes={@ORM\Index(name="mmmi_3", columns={"md_newsletter_user_id"})})
 * @ORM\Entity
 */
class MdNewsLetterGroupUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="md_newsletter_group_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $mdNewsletterGroupId;

    /**
     * @var integer
     *
     * @ORM\Column(name="md_newsletter_user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $mdNewsletterUserId;

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
     * Set mdNewsletterGroupId
     *
     * @param integer $mdNewsletterGroupId
     * @return MdNewsLetterGroupUser
     */
    public function setMdNewsletterGroupId($mdNewsletterGroupId)
    {
        $this->mdNewsletterGroupId = $mdNewsletterGroupId;

        return $this;
    }

    /**
     * Get mdNewsletterGroupId
     *
     * @return integer 
     */
    public function getMdNewsletterGroupId()
    {
        return $this->mdNewsletterGroupId;
    }

    /**
     * Set mdNewsletterUserId
     *
     * @param integer $mdNewsletterUserId
     * @return MdNewsLetterGroupUser
     */
    public function setMdNewsletterUserId($mdNewsletterUserId)
    {
        $this->mdNewsletterUserId = $mdNewsletterUserId;

        return $this;
    }

    /**
     * Get mdNewsletterUserId
     *
     * @return integer 
     */
    public function getMdNewsletterUserId()
    {
        return $this->mdNewsletterUserId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MdNewsLetterGroupUser
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
     * @return MdNewsLetterGroupUser
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
