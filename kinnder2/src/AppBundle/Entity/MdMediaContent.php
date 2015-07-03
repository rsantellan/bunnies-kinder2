<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdMediaContent
 *
 * @ORM\Table(name="md_media_content", uniqueConstraints={@ORM\UniqueConstraint(name="md_media_content_index_idx", columns={"object_class_name", "object_id"})})
 * @ORM\Entity
 */
class MdMediaContent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="object_class_name", type="string", length=128, nullable=false)
     */
    private $objectClassName;

    /**
     * @var integer
     *
     * @ORM\Column(name="object_id", type="integer", nullable=false)
     */
    private $objectId;

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
     * Set objectClassName
     *
     * @param string $objectClassName
     * @return MdMediaContent
     */
    public function setObjectClassName($objectClassName)
    {
        $this->objectClassName = $objectClassName;

        return $this;
    }

    /**
     * Get objectClassName
     *
     * @return string 
     */
    public function getObjectClassName()
    {
        return $this->objectClassName;
    }

    /**
     * Set objectId
     *
     * @param integer $objectId
     * @return MdMediaContent
     */
    public function setObjectId($objectId)
    {
        $this->objectId = $objectId;

        return $this;
    }

    /**
     * Get objectId
     *
     * @return integer 
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return MdMediaContent
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
     * @return MdMediaContent
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
