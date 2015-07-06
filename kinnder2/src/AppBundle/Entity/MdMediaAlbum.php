<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdMediaAlbum
 *
 * @ORM\Table(name="md_media_album", uniqueConstraints={@ORM\UniqueConstraint(name="md_media_album_title_index_idx", columns={"md_media_id", "title"})}, indexes={@ORM\Index(name="md_media_content_id_idx", columns={"md_media_content_id"}), @ORM\Index(name="md_media_id_idx", columns={"md_media_id"})})
 * @ORM\Entity
 */
class MdMediaAlbum
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
     * @ORM\Column(name="md_media_id", type="integer", nullable=true)
     */
    private $mdMediaId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=64, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleteallowed", type="boolean", nullable=false)
     */
    private $deleteallowed;

    /**
     * @var integer
     *
     * @ORM\Column(name="md_media_content_id", type="integer", nullable=true)
     */
    private $mdMediaContentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="counter_content", type="bigint", nullable=true)
     */
    private $counterContent;



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
     * Set mdMediaId
     *
     * @param integer $mdMediaId
     * @return MdMediaAlbum
     */
    public function setMdMediaId($mdMediaId)
    {
        $this->mdMediaId = $mdMediaId;

        return $this;
    }

    /**
     * Get mdMediaId
     *
     * @return integer 
     */
    public function getMdMediaId()
    {
        return $this->mdMediaId;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return MdMediaAlbum
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return MdMediaAlbum
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return MdMediaAlbum
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
     * Set deleteallowed
     *
     * @param boolean $deleteallowed
     * @return MdMediaAlbum
     */
    public function setDeleteallowed($deleteallowed)
    {
        $this->deleteallowed = $deleteallowed;

        return $this;
    }

    /**
     * Get deleteallowed
     *
     * @return boolean 
     */
    public function getDeleteallowed()
    {
        return $this->deleteallowed;
    }

    /**
     * Set mdMediaContentId
     *
     * @param integer $mdMediaContentId
     * @return MdMediaAlbum
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
     * Set counterContent
     *
     * @param integer $counterContent
     * @return MdMediaAlbum
     */
    public function setCounterContent($counterContent)
    {
        $this->counterContent = $counterContent;

        return $this;
    }

    /**
     * Get counterContent
     *
     * @return integer 
     */
    public function getCounterContent()
    {
        return $this->counterContent;
    }
}
