<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioProgenitor
 *
 * @ORM\Table(name="usuario_progenitor", indexes={@ORM\Index(name="usuario_progenitor_progenitor_id_progenitor_id", columns={"progenitor_id"})})
 * @ORM\Entity
 */
class UsuarioProgenitor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="usuario_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $usuarioId;

    /**
     * @var integer
     *
     * @ORM\Column(name="progenitor_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $progenitorId;



    /**
     * Set usuarioId
     *
     * @param integer $usuarioId
     * @return UsuarioProgenitor
     */
    public function setUsuarioId($usuarioId)
    {
        $this->usuarioId = $usuarioId;

        return $this;
    }

    /**
     * Get usuarioId
     *
     * @return integer 
     */
    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    /**
     * Set progenitorId
     *
     * @param integer $progenitorId
     * @return UsuarioProgenitor
     */
    public function setProgenitorId($progenitorId)
    {
        $this->progenitorId = $progenitorId;

        return $this;
    }

    /**
     * Get progenitorId
     *
     * @return integer 
     */
    public function getProgenitorId()
    {
        return $this->progenitorId;
    }
}
