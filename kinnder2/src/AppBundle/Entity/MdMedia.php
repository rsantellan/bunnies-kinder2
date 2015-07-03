<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdMedia
 *
 * @ORM\Table(name="md_media", uniqueConstraints={@ORM\UniqueConstraint(name="md_media_index_idx", columns={"object_class_name", "object_id"})})
 * @ORM\Entity
 */
class MdMedia
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
     * @return MdMedia
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
     * @return MdMedia
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
}
