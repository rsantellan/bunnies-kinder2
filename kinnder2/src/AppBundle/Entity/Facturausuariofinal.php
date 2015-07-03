<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facturausuariofinal
 *
 * @ORM\Table(name="facturausuariofinal", indexes={@ORM\Index(name="facturausuariofinal_factura_final_id_facturaFinal_id", columns={"factura_final_id"})})
 * @ORM\Entity
 */
class Facturausuariofinal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="factura_usuario_id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $facturaUsuarioId;

    /**
     * @var integer
     *
     * @ORM\Column(name="factura_final_id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $facturaFinalId;



    /**
     * Set facturaUsuarioId
     *
     * @param integer $facturaUsuarioId
     * @return Facturausuariofinal
     */
    public function setFacturaUsuarioId($facturaUsuarioId)
    {
        $this->facturaUsuarioId = $facturaUsuarioId;

        return $this;
    }

    /**
     * Get facturaUsuarioId
     *
     * @return integer 
     */
    public function getFacturaUsuarioId()
    {
        return $this->facturaUsuarioId;
    }

    /**
     * Set facturaFinalId
     *
     * @param integer $facturaFinalId
     * @return Facturausuariofinal
     */
    public function setFacturaFinalId($facturaFinalId)
    {
        $this->facturaFinalId = $facturaFinalId;

        return $this;
    }

    /**
     * Get facturaFinalId
     *
     * @return integer 
     */
    public function getFacturaFinalId()
    {
        return $this->facturaFinalId;
    }
}
