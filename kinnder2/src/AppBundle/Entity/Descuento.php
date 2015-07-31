<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Descuentos
 *
 * @ORM\Table(name="descuento", uniqueConstraints={@ORM\UniqueConstraint(name="cantidad_de_hermanos", columns={"cantidad_de_hermanos"})})
 * @ORM\Entity
 */
class Descuento
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
     * @ORM\Column(name="cantidad_de_hermanos", type="bigint", nullable=false)
     */
    private $cantidadDeHermanos;

    /**
     * @var integer
     *
     * @ORM\Column(name="porcentaje", type="bigint", nullable=false)
     */
    private $porcentaje;


    /**
     * Set id
     *
     * @param integer $id
     * @return Descuentos
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
     * Set cantidadDeHermanos
     *
     * @param integer $cantidadDeHermanos
     * @return Descuentos
     */
    public function setCantidadDeHermanos($cantidadDeHermanos)
    {
        $this->cantidadDeHermanos = $cantidadDeHermanos;

        return $this;
    }

    /**
     * Get cantidadDeHermanos
     *
     * @return integer 
     */
    public function getCantidadDeHermanos()
    {
        return $this->cantidadDeHermanos;
    }

    /**
     * Set porcentaje
     *
     * @param integer $porcentaje
     * @return Descuentos
     */
    public function setPorcentaje($porcentaje)
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }

    /**
     * Get porcentaje
     *
     * @return integer 
     */
    public function getPorcentaje()
    {
        return $this->porcentaje;
    }
}
