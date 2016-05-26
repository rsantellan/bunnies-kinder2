<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdGaleriaTranslation.
 *
 * @ORM\Table(name="md_galeria_translation")
 * @ORM\Entity
 */
class MdGaleriaTranslation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=2)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $lang;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=128, nullable=true)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=false)
     */
    private $descripcion;

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return MdGaleriaTranslation
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
     * Set lang.
     *
     * @param string $lang
     *
     * @return MdGaleriaTranslation
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang.
     *
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set titulo.
     *
     * @param string $titulo
     *
     * @return MdGaleriaTranslation
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo.
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set descripcion.
     *
     * @param string $descripcion
     *
     * @return MdGaleriaTranslation
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion.
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
