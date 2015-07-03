<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdMediaVimeoVideo
 *
 * @ORM\Table(name="md_media_vimeo_video")
 * @ORM\Entity
 */
class MdMediaVimeoVideo
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
     * @ORM\Column(name="vimeo_url", type="string", length=64, nullable=false)
     */
    private $vimeoUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="src", type="string", length=255, nullable=false)
     */
    private $src;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=64, nullable=false)
     */
    private $duration;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var boolean
     *
     * @ORM\Column(name="avatar_width", type="boolean", nullable=true)
     */
    private $avatarWidth;

    /**
     * @var boolean
     *
     * @ORM\Column(name="avatar_height", type="boolean", nullable=true)
     */
    private $avatarHeight;

    /**
     * @var string
     *
     * @ORM\Column(name="author_name", type="string", length=255, nullable=true)
     */
    private $authorName;

    /**
     * @var string
     *
     * @ORM\Column(name="author_url", type="string", length=255, nullable=true)
     */
    private $authorUrl;



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
     * Set vimeoUrl
     *
     * @param string $vimeoUrl
     * @return MdMediaVimeoVideo
     */
    public function setVimeoUrl($vimeoUrl)
    {
        $this->vimeoUrl = $vimeoUrl;

        return $this;
    }

    /**
     * Get vimeoUrl
     *
     * @return string 
     */
    public function getVimeoUrl()
    {
        return $this->vimeoUrl;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return MdMediaVimeoVideo
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
     * Set src
     *
     * @param string $src
     * @return MdMediaVimeoVideo
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string 
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set duration
     *
     * @param string $duration
     * @return MdMediaVimeoVideo
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return MdMediaVimeoVideo
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
     * Set avatar
     *
     * @param string $avatar
     * @return MdMediaVimeoVideo
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set avatarWidth
     *
     * @param boolean $avatarWidth
     * @return MdMediaVimeoVideo
     */
    public function setAvatarWidth($avatarWidth)
    {
        $this->avatarWidth = $avatarWidth;

        return $this;
    }

    /**
     * Get avatarWidth
     *
     * @return boolean 
     */
    public function getAvatarWidth()
    {
        return $this->avatarWidth;
    }

    /**
     * Set avatarHeight
     *
     * @param boolean $avatarHeight
     * @return MdMediaVimeoVideo
     */
    public function setAvatarHeight($avatarHeight)
    {
        $this->avatarHeight = $avatarHeight;

        return $this;
    }

    /**
     * Get avatarHeight
     *
     * @return boolean 
     */
    public function getAvatarHeight()
    {
        return $this->avatarHeight;
    }

    /**
     * Set authorName
     *
     * @param string $authorName
     * @return MdMediaVimeoVideo
     */
    public function setAuthorName($authorName)
    {
        $this->authorName = $authorName;

        return $this;
    }

    /**
     * Get authorName
     *
     * @return string 
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * Set authorUrl
     *
     * @param string $authorUrl
     * @return MdMediaVimeoVideo
     */
    public function setAuthorUrl($authorUrl)
    {
        $this->authorUrl = $authorUrl;

        return $this;
    }

    /**
     * Get authorUrl
     *
     * @return string 
     */
    public function getAuthorUrl()
    {
        return $this->authorUrl;
    }
}
