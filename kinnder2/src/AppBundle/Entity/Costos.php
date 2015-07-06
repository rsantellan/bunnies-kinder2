<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Costos
 *
 * @ORM\Table(name="costos")
 * @ORM\Entity
 */
class Costos
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
     * @var float
     *
     * @ORM\Column(name="matricula", type="float", precision=10, scale=2, nullable=false)
     */
    private $matricula;

    /**
     * @var float
     *
     * @ORM\Column(name="matutino", type="float", precision=10, scale=2, nullable=false)
     */
    private $matutino;

    /**
     * @var float
     *
     * @ORM\Column(name="vespertino", type="float", precision=10, scale=2, nullable=false)
     */
    private $vespertino;

    /**
     * @var float
     *
     * @ORM\Column(name="doble_horario", type="float", precision=10, scale=2, nullable=false)
     */
    private $dobleHorario;



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
     * Set matricula
     *
     * @param float $matricula
     * @return Costos
     */
    public function setMatricula($matricula)
    {
        $this->matricula = $matricula;

        return $this;
    }

    /**
     * Get matricula
     *
     * @return float 
     */
    public function getMatricula()
    {
        return $this->matricula;
    }

    /**
     * Set matutino
     *
     * @param float $matutino
     * @return Costos
     */
    public function setMatutino($matutino)
    {
        $this->matutino = $matutino;

        return $this;
    }

    /**
     * Get matutino
     *
     * @return float 
     */
    public function getMatutino()
    {
        return $this->matutino;
    }

    /**
     * Set vespertino
     *
     * @param float $vespertino
     * @return Costos
     */
    public function setVespertino($vespertino)
    {
        $this->vespertino = $vespertino;

        return $this;
    }

    /**
     * Get vespertino
     *
     * @return float 
     */
    public function getVespertino()
    {
        return $this->vespertino;
    }

    /**
     * Set dobleHorario
     *
     * @param float $dobleHorario
     * @return Costos
     */
    public function setDobleHorario($dobleHorario)
    {
        $this->dobleHorario = $dobleHorario;

        return $this;
    }

    /**
     * Get dobleHorario
     *
     * @return float 
     */
    public function getDobleHorario()
    {
        return $this->dobleHorario;
    }
}
