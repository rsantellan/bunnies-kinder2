<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exoneracion
 *
 * @ORM\Table(name="exoneracion", indexes={@ORM\Index(name="usuario_id_idx", columns={"usuario_id"})})
 * @ORM\Entity
 */
class Exoneracion
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
     * 
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="exoneraciones")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * 
     **/       
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="mes", type="string", nullable=true)
     */
    private $mes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;



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
     * Set mes
     *
     * @param string $mes
     * @return Exoneracion
     */
    public function setMes($mes)
    {
        $this->mes = $mes;

        return $this;
    }

    /**
     * Get mes
     *
     * @return string 
     */
    public function getMes()
    {
        return $this->mes;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Exoneracion
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     * @return Exoneracion
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
