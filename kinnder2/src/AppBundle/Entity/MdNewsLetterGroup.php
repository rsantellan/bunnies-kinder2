<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdNewsLetterGroup
 *
 * @ORM\Table(name="md_news_letter_group")
 * @ORM\Entity
 */
class MdNewsLetterGroup
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
     * @ORM\Column(name="name", type="text", nullable=false)
     */
    private $name;


    /**
     * 
     * @ORM\OneToOne(targetEntity="Actividad", mappedBy="mdNewsLetterGroup")
     *
     */
    private $actividad;

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
     * Set name
     *
     * @param string $name
     * @return MdNewsLetterGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set actividad
     *
     * @param \AppBundle\Entity\Actividades $actividad
     * @return MdNewsLetterGroup
     */
    public function setActividad(\AppBundle\Entity\Actividades $actividad = null)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return \AppBundle\Entity\Actividades 
     */
    public function getActividad()
    {
        return $this->actividad;
    }
}
