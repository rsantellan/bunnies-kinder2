<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdNewsLetterGroupSended
 *
 * @ORM\Table(name="md_news_letter_group_sended", indexes={@ORM\Index(name="mmmi_1", columns={"md_newsletter_contend_sended_id"})})
 * @ORM\Entity
 */
class MdNewsLetterGroupSended
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
     * @ORM\Column(name="md_newsletter_contend_sended_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $mdNewsletterContendSendedId;

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
     * @return MdNewsLetterGroupSended
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
     * Set mdNewsletterContendSendedId
     *
     * @param integer $mdNewsletterContendSendedId
     * @return MdNewsLetterGroupSended
     */
    public function setMdNewsletterContendSendedId($mdNewsletterContendSendedId)
    {
        $this->mdNewsletterContendSendedId = $mdNewsletterContendSendedId;

        return $this;
    }

    /**
     * Get mdNewsletterContendSendedId
     *
     * @return integer 
     */
    public function getMdNewsletterContendSendedId()
    {
        return $this->mdNewsletterContendSendedId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MdNewsLetterGroupSended
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
     * @return MdNewsLetterGroupSended
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
