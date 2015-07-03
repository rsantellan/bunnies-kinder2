<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Actividades
 *
 * @ORM\Table(name="actividades", indexes={@ORM\Index(name="md_news_letter_group_id_idx", columns={"md_news_letter_group_id"})})
 * @ORM\Entity
 */
class Actividades
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
     * @ORM\OneToOne(targetEntity="MdNewsLetterGroup", inversedBy="actividad")
     * @ORM\JoinColumn(name="md_news_letter_group_id", referencedColumnName="id")
     * 
     * 
     **/
    private $mdNewsLetterGroup;
    

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
     * Set mdNewsLetterGroup
     *
     * @param \AppBundle\Entity\MdNewsLetterGroup $mdNewsLetterGroup
     * @return Actividades
     */
    public function setMdNewsLetterGroup(\AppBundle\Entity\MdNewsLetterGroup $mdNewsLetterGroup = null)
    {
        $this->mdNewsLetterGroup = $mdNewsLetterGroup;

        return $this;
    }

    /**
     * Get mdNewsLetterGroup
     *
     * @return \AppBundle\Entity\MdNewsLetterGroup 
     */
    public function getMdNewsLetterGroup()
    {
        return $this->mdNewsLetterGroup;
    }
}
