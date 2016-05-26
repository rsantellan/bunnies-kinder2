<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Horario.
 *
 * @ORM\Table(name="horario")
 * @ORM\Entity
 */
class Horario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="dbname", type="string", length=255, unique = true)
     */
    private $dbname;

    /**
     * @ORM\OneToMany(targetEntity="Estudiante", mappedBy="horario")
     */
    private $estudiantes;
    /**
     * Set id.
     *
     * @return int
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
     * Set name.
     *
     * @param string $name
     *
     * @return Horario
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->estudiantes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add estudiantes.
     *
     * @param \AppBundle\Entity\Estudiante $estudiantes
     *
     * @return Horario
     */
    public function addEstudiante(\AppBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes[] = $estudiantes;

        return $this;
    }

    /**
     * Remove estudiantes.
     *
     * @param \AppBundle\Entity\Estudiante $estudiantes
     */
    public function removeEstudiante(\AppBundle\Entity\Estudiante $estudiantes)
    {
        $this->estudiantes->removeElement($estudiantes);
    }

    /**
     * Get estudiantes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEstudiantes()
    {
        return $this->estudiantes;
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Set dbname.
     *
     * @param string $dbname
     *
     * @return Horario
     */
    public function setDbname($dbname)
    {
        $this->dbname = $dbname;

        return $this;
    }

    /**
     * Get dbname.
     *
     * @return string
     */
    public function getDbname()
    {
        return $this->dbname;
    }
}
