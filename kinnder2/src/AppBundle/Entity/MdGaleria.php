<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdGaleria
 *
 * @ORM\Table(name="md_galeria", uniqueConstraints={@ORM\UniqueConstraint(name="md_galeria_position_sortable_idx", columns={"position"})})
 * @ORM\Entity
 */
class MdGaleria
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
     * @var boolean
     *
     * @ORM\Column(name="curso_verde", type="boolean", nullable=true, options={"default" = 0})
     */
    private $cursoVerde;

    /**
     * @var boolean
     *
     * @ORM\Column(name="curso_rojo", type="boolean", nullable=true, options={"default" = 0})
     */
    private $cursoRojo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="curso_amarillo", type="boolean", nullable=true, options={"default" = 0})
     */
    private $cursoAmarillo;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="bigint", nullable=true)
     */
    private $position;



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
     * Set cursoVerde
     *
     * @param boolean $cursoVerde
     * @return MdGaleria
     */
    public function setCursoVerde($cursoVerde)
    {
        $this->cursoVerde = $cursoVerde;

        return $this;
    }

    /**
     * Get cursoVerde
     *
     * @return boolean 
     */
    public function getCursoVerde()
    {
        return $this->cursoVerde;
    }

    /**
     * Set cursoRojo
     *
     * @param boolean $cursoRojo
     * @return MdGaleria
     */
    public function setCursoRojo($cursoRojo)
    {
        $this->cursoRojo = $cursoRojo;

        return $this;
    }

    /**
     * Get cursoRojo
     *
     * @return boolean 
     */
    public function getCursoRojo()
    {
        return $this->cursoRojo;
    }

    /**
     * Set cursoAmarillo
     *
     * @param boolean $cursoAmarillo
     * @return MdGaleria
     */
    public function setCursoAmarillo($cursoAmarillo)
    {
        $this->cursoAmarillo = $cursoAmarillo;

        return $this;
    }

    /**
     * Get cursoAmarillo
     *
     * @return boolean 
     */
    public function getCursoAmarillo()
    {
        return $this->cursoAmarillo;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return MdGaleria
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }
}
