<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actividades
 *
 * @ORM\Table(name="actividad", indexes={@ORM\Index(name="md_news_letter_group_id_idx", columns={"md_news_letter_group_id"})})
 * @ORM\Entity
 */
class Actividad
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
     * @ORM\Column(name="nombre", type="string", length=64, nullable=false)
     */
    private $nombre;

    /**
     * @var float
     *
     * @ORM\Column(name="costo", type="float", precision=10, scale=2, nullable=false)
     */
    private $costo;

    /**
     * @var string
     *
     * @ORM\Column(name="horario", type="string", nullable=true)
     */
    private $horario;


    /**
     * 
     * @ORM\ManyToOne(targetEntity="\Maith\NewsletterBundle\Entity\UserGroup")
     * @ORM\JoinColumn(name="md_news_letter_group_id", referencedColumnName="id")
     * 
     * 
     **/
    private $newsLetterGroup;
    
    /**
     * @ORM\ManyToMany(targetEntity="Estudiante", mappedBy="actividades")
     **/    
    private $estudiantes;    

    
    /**
     * Set id
     *
     * @return integer 
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
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
     * Set nombre
     *
     * @param string $nombre
     * @return Actividades
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set costo
     *
     * @param float $costo
     * @return Actividades
     */
    public function setCosto($costo)
    {
        $this->costo = $costo;

        return $this;
    }

    /**
     * Get costo
     *
     * @return float 
     */
    public function getCosto()
    {
        return $this->costo;
    }

    /**
     * Set horario
     *
     * @param string $horario
     * @return Actividades
     */
    public function setHorario($horario)
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * Get horario
     *
     * @return string 
     */
    public function getHorario()
    {
        return $this->horario;
    }

    

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->estudiantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add estudiantes
     *
     * @param \AppBundle\Entity\Estudiante $estudiantes
     * @return Actividad
     */
    public function addEstudiante(\AppBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes[] = $estudiantes;

        return $this;
    }

    /**
     * Remove estudiantes
     *
     * @param \AppBundle\Entity\Estudiante $estudiantes
     */
    public function removeEstudiante(\AppBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes->removeElement($estudiantes);
    }

    /**
     * Get estudiantes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEstudiantes()
    {
        return $this->estudiantes;
    }

    /**
     * Set newsLetterGroup
     *
     * @param \Maith\NewsletterBundle\Entity\UserGroup $newsLetterGroup
     * @return Actividad
     */
    public function setNewsLetterGroup(\Maith\NewsletterBundle\Entity\UserGroup $newsLetterGroup = null)
    {
        $this->newsLetterGroup = $newsLetterGroup;

        return $this;
    }

    /**
     * Get newsLetterGroup
     *
     * @return \Maith\NewsletterBundle\Entity\UserGroup 
     */
    public function getNewsLetterGroup()
    {
        return $this->newsLetterGroup;
    }
}
