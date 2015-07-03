<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdMediaAlbumContent
 *
 * @ORM\Table(name="md_media_album_content", indexes={@ORM\Index(name="md_media_album_content_index_idx", columns={"priority"}), @ORM\Index(name="md_media_album_content_md_media_content_id_md_media_content_id", columns={"md_media_content_id"})})
 * @ORM\Entity
 */
class MdMediaAlbumContent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="md_media_album_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $mdMediaAlbumId;

    /**
     * @var integer
     *
     * @ORM\Column(name="md_media_content_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $mdMediaContentId;

    /**
     * @var string
     *
     * @ORM\Column(name="object_class_name", type="string", length=128, nullable=false)
     */
    private $objectClassName;

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="bigint", nullable=false)
     */
    private $priority;



    /**
     * Set mdMediaAlbumId
     *
     * @param integer $mdMediaAlbumId
     * @return MdMediaAlbumContent
     */
    public function setMdMediaAlbumId($mdMediaAlbumId)
    {
        $this->mdMediaAlbumId = $mdMediaAlbumId;

        return $this;
    }

    /**
     * Get mdMediaAlbumId
     *
     * @return integer 
     */
    public function getMdMediaAlbumId()
    {
        return $this->mdMediaAlbumId;
    }

    /**
     * Set mdMediaContentId
     *
     * @param integer $mdMediaContentId
     * @return MdMediaAlbumContent
     */
    public function setMdMediaContentId($mdMediaContentId)
    {
        $this->mdMediaContentId = $mdMediaContentId;

        return $this;
    }

    /**
     * Get mdMediaContentId
     *
     * @return integer 
     */
    public function getMdMediaContentId()
    {
        return $this->mdMediaContentId;
    }

    /**
     * Set objectClassName
     *
     * @param string $objectClassName
     * @return MdMediaAlbumContent
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
     * Set priority
     *
     * @param integer $priority
     * @return MdMediaAlbumContent
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }
}
