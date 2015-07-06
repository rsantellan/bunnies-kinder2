<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdNewsletterContentSended
 *
 * @ORM\Table(name="md_newsletter_content_sended", indexes={@ORM\Index(name="md_newsletter_content_id_idx", columns={"md_newsletter_content_id"})})
 * @ORM\Entity
 */
class MdNewsletterContentSended
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
     * @var string
     *
     * @ORM\Column(name="subject", type="text", nullable=false)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="blob", nullable=false)
     */
    private $body;

    /**
     * @var integer
     *
     * @ORM\Column(name="send_counter", type="integer", nullable=false)
     */
    private $sendCounter;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sending_date", type="datetime", nullable=true)
     */
    private $sendingDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sended", type="boolean", nullable=true)
     */
    private $sended;

    /**
     * @var integer
     *
     * @ORM\Column(name="for_status", type="smallint", nullable=true)
     */
    private $forStatus;

    /**
     * @var integer
     *
     * @ORM\Column(name="md_newsletter_content_id", type="integer", nullable=false)
     */
    private $mdNewsletterContentId;

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
     * Set subject
     *
     * @param string $subject
     * @return MdNewsletterContentSended
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return MdNewsletterContentSended
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set sendCounter
     *
     * @param integer $sendCounter
     * @return MdNewsletterContentSended
     */
    public function setSendCounter($sendCounter)
    {
        $this->sendCounter = $sendCounter;

        return $this;
    }

    /**
     * Get sendCounter
     *
     * @return integer 
     */
    public function getSendCounter()
    {
        return $this->sendCounter;
    }

    /**
     * Set sendingDate
     *
     * @param \DateTime $sendingDate
     * @return MdNewsletterContentSended
     */
    public function setSendingDate($sendingDate)
    {
        $this->sendingDate = $sendingDate;

        return $this;
    }

    /**
     * Get sendingDate
     *
     * @return \DateTime 
     */
    public function getSendingDate()
    {
        return $this->sendingDate;
    }

    /**
     * Set sended
     *
     * @param boolean $sended
     * @return MdNewsletterContentSended
     */
    public function setSended($sended)
    {
        $this->sended = $sended;

        return $this;
    }

    /**
     * Get sended
     *
     * @return boolean 
     */
    public function getSended()
    {
        return $this->sended;
    }

    /**
     * Set forStatus
     *
     * @param integer $forStatus
     * @return MdNewsletterContentSended
     */
    public function setForStatus($forStatus)
    {
        $this->forStatus = $forStatus;

        return $this;
    }

    /**
     * Get forStatus
     *
     * @return integer 
     */
    public function getForStatus()
    {
        return $this->forStatus;
    }

    /**
     * Set mdNewsletterContentId
     *
     * @param integer $mdNewsletterContentId
     * @return MdNewsletterContentSended
     */
    public function setMdNewsletterContentId($mdNewsletterContentId)
    {
        $this->mdNewsletterContentId = $mdNewsletterContentId;

        return $this;
    }

    /**
     * Get mdNewsletterContentId
     *
     * @return integer 
     */
    public function getMdNewsletterContentId()
    {
        return $this->mdNewsletterContentId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MdNewsletterContentSended
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
     * @return MdNewsletterContentSended
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
