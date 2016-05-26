<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Descuentos.
 *
 * @ORM\Table(name="descuento", uniqueConstraints={@ORM\UniqueConstraint(name="cantidad_de_hermanos", columns={"cantidad_de_hermanos"})})
 * @ORM\Entity
 */
class Descuento
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
     * @var int
     *
     * @ORM\Column(name="cantidad_de_hermanos", type="bigint", nullable=false)
     */
    private $cantidadDeHermanos;

    /**
     * @var int
     *
     * @ORM\Column(name="porcentaje", type="bigint", nullable=false)
     */
    private $porcentaje;

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return Descuentos
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set cantidadDeHermanos.
     *
     * @param int $cantidadDeHermanos
     *
     * @return Descuentos
     */
    public function setCantidadDeHermanos($cantidadDeHermanos)
    {
        $this->cantidadDeHermanos = $cantidadDeHermanos;

        return $this;
    }

    /**
     * Get cantidadDeHermanos.
     *
     * @return int
     */
    public function getCantidadDeHermanos()
    {
        return $this->cantidadDeHermanos;
    }

    /**
     * Set porcentaje.
     *
     * @param int $porcentaje
     *
     * @return Descuentos
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje.
     *
     * @return int
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }
}
