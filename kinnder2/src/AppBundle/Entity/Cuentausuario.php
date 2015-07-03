<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuentausuario
 *
 * @ORM\Table(name="cuentausuario", indexes={@ORM\Index(name="cuentausuario_usuario_id_usuario_id", columns={"usuario_id"})})
 * @ORM\Entity
 */
class Cuentausuario
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cuenta_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $cuentaId;

    /**
     * @var integer
     *
     * @ORM\Column(name="usuario_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $usuarioId;



    /**
     * Set cuentaId
     *
     * @param integer $cuentaId
     * @return Cuentausuario
     */
    public function setCuentaId($cuentaId)
    {
        $this->cuentaId = $cuentaId;

        return $this;
    }

    /**
     * Get cuentaId
     *
     * @return integer 
     */
    public function getCuentaId()
    {
        return $this->cuentaId;
    }

    /**
     * Set usuarioId
     *
     * @param integer $usuarioId
     * @return Cuentausuario
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
}
