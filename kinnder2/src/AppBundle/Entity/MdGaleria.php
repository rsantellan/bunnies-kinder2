<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdGaleria.
 *
 * @ORM\Table(name="md_galeria", uniqueConstraints={@ORM\UniqueConstraint(name="md_galeria_position_sortable_idx", columns={"position"})})
 * @ORM\Entity
 */
class MdGaleria
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="curso_verde", type="boolean", nullable=true, options={"default" = 0})
     */
    private $cursoVerde;

    /**
     * @var bool
     *
     * @ORM\Column(name="curso_rojo", type="boolean", nullable=true, options={"default" = 0})
     */
    private $cursoRojo;

    /**
     * @var bool
     *
     * @ORM\Column(name="curso_amarillo", type="boolean", nullable=true, options={"default" = 0})
     */
    private $cursoAmarillo;

    /**
     * @var int
     *
     * @ORM\Column(name="position", type="bigint", nullable=true)
     */
    private $position;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cursoVerde.
     *
     * @param bool $cursoVerde
     *
     * @return MdGaleria
     */
    public function setCursoVerde($cursoVerde)
    {
        $this->cursoVerde = $cursoVerde;

        return $this;
    }

    /**
     * Get cursoVerde.
     *
     * @return bool
     */
    public function getCursoVerde()
    {
        return $this->cursoVerde;
    }

    /**
     * Set cursoRojo.
     *
     * @param bool $cursoRojo
     *
     * @return MdGaleria
     */
    public function setCursoRojo($cursoRojo)
    {
        $this->cursoRojo = $cursoRojo;

        return $this;
    }

    /**
     * Get cursoRojo.
     *
     * @return bool
     */
    public function getCursoRojo()
    {
        return $this->cursoRojo;
    }

    /**
     * Set cursoAmarillo.
     *
     * @param bool $cursoAmarillo
     *
     * @return MdGaleria
     */
    public function setCursoAmarillo($cursoAmarillo)
    {
        $this->cursoAmarillo = $cursoAmarillo;

        return $this;
    }

    /**
     * Get cursoAmarillo.
     *
     * @return bool
     */
    public function getCursoAmarillo()
    {
        return $this->cursoAmarillo;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return MdGaleria
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }
}
