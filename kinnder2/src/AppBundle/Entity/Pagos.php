<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pagos
 *
 * @ORM\Table(name="pagos", indexes={@ORM\Index(name="usuario_id_idx", columns={"usuario_id"})})
 * @ORM\Entity
 */
class Pagos
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
     * @ORM\ManyToOne(targetEntity="Estudiante", inversedBy="pagos")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * 
     **/       
    private $estudiante;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="bigint", nullable=false)
     */
    private $price;

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
     * @var boolean
     *
     * @ORM\Column(name="out_of_date", type="boolean", nullable=false)
     */
    private $outOfDate;



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
     * Set price
     *
     * @param integer $price
     * @return Pagos
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set mes
     *
     * @param string $mes
     * @return Pagos
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
     * @return Pagos
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
     * Set outOfDate
     *
     * @param boolean $outOfDate
     * @return Pagos
     */
    public function setOutOfDate($outOfDate)
    {
        $this->outOfDate = $outOfDate;

        return $this;
    }

    /**
     * Get outOfDate
     *
     * @return boolean 
     */
    public function getOutOfDate()
    {
        return $this->outOfDate;
    }

}
