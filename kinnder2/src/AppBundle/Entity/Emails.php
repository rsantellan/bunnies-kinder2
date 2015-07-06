<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emails
 *
 * @ORM\Table(name="emails", uniqueConstraints={@ORM\UniqueConstraint(name="type_index_idx", columns={"type"})})
 * @ORM\Entity
 */
class Emails
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
     * @ORM\Column(name="type", type="string", length=32, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="from_name", type="string", length=64, nullable=false)
     */
    private $fromName;

    /**
     * @var string
     *
     * @ORM\Column(name="from_mail", type="string", length=64, nullable=false)
     */
    private $fromMail;



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
     * Set type
     *
     * @param string $type
     * @return Emails
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set fromName
     *
     * @param string $fromName
     * @return Emails
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Get fromName
     *
     * @return string 
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * Set fromMail
     *
     * @param string $fromMail
     * @return Emails
     */
    public function setFromMail($fromMail)
    {
        $this->fromMail = $fromMail;

        return $this;
    }

    /**
     * Get fromMail
     *
     * @return string 
     */
    public function getFromMail()
    {
        return $this->fromMail;
    }
}
