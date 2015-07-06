<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdNewsletterSend
 *
 * @ORM\Table(name="md_newsletter_send", indexes={@ORM\Index(name="md_news_letter_user_id_idx", columns={"md_news_letter_user_id"}), @ORM\Index(name="md_newsletter_content_sended_id_idx", columns={"md_newsletter_content_sended_id"})})
 * @ORM\Entity
 */
class MdNewsletterSend
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
     * @ORM\Column(name="md_news_letter_user_id", type="integer", nullable=false)
     */
    private $mdNewsLetterUserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="md_newsletter_content_sended_id", type="integer", nullable=false)
     */
    private $mdNewsletterContentSendedId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sending_date", type="datetime", nullable=true)
     */
    private $sendingDate;

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
     * Set mdNewsLetterUserId
     *
     * @param integer $mdNewsLetterUserId
     * @return MdNewsletterSend
     */
    public function setMdNewsLetterUserId($mdNewsLetterUserId)
    {
        $this->mdNewsLetterUserId = $mdNewsLetterUserId;

        return $this;
    }

    /**
     * Get mdNewsLetterUserId
     *
     * @return integer 
     */
    public function getMdNewsLetterUserId()
    {
        return $this->mdNewsLetterUserId;
    }

    /**
     * Set mdNewsletterContentSendedId
     *
     * @param integer $mdNewsletterContentSendedId
     * @return MdNewsletterSend
     */
    public function setMdNewsletterContentSendedId($mdNewsletterContentSendedId)
    {
        $this->mdNewsletterContentSendedId = $mdNewsletterContentSendedId;

        return $this;
    }

    /**
     * Get mdNewsletterContentSendedId
     *
     * @return integer 
     */
    public function getMdNewsletterContentSendedId()
    {
        return $this->mdNewsletterContentSendedId;
    }

    /**
     * Set sendingDate
     *
     * @param \DateTime $sendingDate
     * @return MdNewsletterSend
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MdNewsletterSend
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
     * @return MdNewsletterSend
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
