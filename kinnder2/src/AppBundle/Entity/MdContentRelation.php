<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdContentRelation
 *
 * @ORM\Table(name="md_content_relation", indexes={@ORM\Index(name="md_content_relation_md_content_id_second_md_content_id", columns={"md_content_id_second"})})
 * @ORM\Entity
 */
class MdContentRelation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="md_content_id_first", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $mdContentIdFirst;

    /**
     * @var integer
     *
     * @ORM\Column(name="md_content_id_second", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $mdContentIdSecond;

    /**
     * @var string
     *
     * @ORM\Column(name="object_class_name", type="string", length=128, nullable=false)
     */
    private $objectClassName;

    /**
     * @var string
     *
     * @ORM\Column(name="profile_name", type="string", length=128, nullable=true)
     */
    private $profileName;



    /**
     * Set mdContentIdFirst
     *
     * @param integer $mdContentIdFirst
     * @return MdContentRelation
     */
    public function setMdContentIdFirst($mdContentIdFirst)
    {
        $this->mdContentIdFirst = $mdContentIdFirst;

        return $this;
    }

    /**
     * Get mdContentIdFirst
     *
     * @return integer 
     */
    public function getMdContentIdFirst()
    {
        return $this->mdContentIdFirst;
    }

    /**
     * Set mdContentIdSecond
     *
     * @param integer $mdContentIdSecond
     * @return MdContentRelation
     */
    public function setMdContentIdSecond($mdContentIdSecond)
    {
        $this->mdContentIdSecond = $mdContentIdSecond;

        return $this;
    }

    /**
     * Get mdContentIdSecond
     *
     * @return integer 
     */
    public function getMdContentIdSecond()
    {
        return $this->mdContentIdSecond;
    }

    /**
     * Set objectClassName
     *
     * @param string $objectClassName
     * @return MdContentRelation
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
     * Set profileName
     *
     * @param string $profileName
     * @return MdContentRelation
     */
    public function setProfileName($profileName)
    {
        $this->profileName = $profileName;

        return $this;
    }

    /**
     * Get profileName
     *
     * @return string 
     */
    public function getProfileName()
    {
        return $this->profileName;
    }
}
