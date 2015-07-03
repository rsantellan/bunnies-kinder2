<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuentapadre
 *
 * @ORM\Table(name="cuentapadre", indexes={@ORM\Index(name="cuentapadre_progenitor_id_progenitor_id", columns={"progenitor_id"})})
 * @ORM\Entity
 */
class Cuentapadre
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
     * @ORM\Column(name="progenitor_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $progenitorId;



    /**
     * Set cuentaId
     *
     * @param integer $cuentaId
     * @return Cuentapadre
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
     * Set progenitorId
     *
     * @param integer $progenitorId
     * @return Cuentapadre
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
