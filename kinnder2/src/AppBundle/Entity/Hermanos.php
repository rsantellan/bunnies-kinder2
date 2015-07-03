<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hermanos
 *
 * @ORM\Table(name="hermanos", indexes={@ORM\Index(name="hermanos_usuario_to_usuario_id", columns={"usuario_to"})})
 * @ORM\Entity
 */
class Hermanos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="usuario_from", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $usuarioFrom;

    /**
     * @var integer
     *
     * @ORM\Column(name="usuario_to", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $usuarioTo;



    /**
     * Set usuarioFrom
     *
     * @param integer $usuarioFrom
     * @return Hermanos
     */
    public function setUsuarioFrom($usuarioFrom)
    {
        $this->usuarioFrom = $usuarioFrom;

        return $this;
    }

    /**
     * Get usuarioFrom
     *
     * @return integer 
     */
    public function getUsuarioFrom()
    {
        return $this->usuarioFrom;
    }

    /**
     * Set usuarioTo
     *
     * @param integer $usuarioTo
     * @return Hermanos
     */
    public function setUsuarioTo($usuarioTo)
    {
        $this->usuarioTo = $usuarioTo;

        return $this;
    }

    /**
     * Get usuarioTo
     *
     * @return integer 
     */
    public function getUsuarioTo()
    {
        return $this->usuarioTo;
    }
}
