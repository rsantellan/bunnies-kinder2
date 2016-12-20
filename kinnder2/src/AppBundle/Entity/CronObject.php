<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CronObject
 *
 * @ORM\Table(name="cron_objects")
 * @ORM\Entity
 */
class CronObject
{
    const RECREATECOSTOS = 1;
    const RECREATEACTIVIDAD = 2;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="typeName", type="string", length=255)
     */
    private $typeName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="executed", type="boolean")
     */
    private $executed;

    /**
     * @var string
     *
     * @ORM\Column(name="createdBy", type="string", length=255)
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetimetz")
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="runningtime", type="integer")
     */
    private $runningtime;

    /**
     * @var string
     *
     * @ORM\Column(name="extraData", type="string", length=255)
     */
    private $extraData;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

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
     * Set type
     *
     * @param integer $type
     * @return CronObject
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set typeName
     *
     * @param string $typeName
     * @return CronObject
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;

        return $this;
    }

    /**
     * Get typeName
     *
     * @return string 
     */
    public function getTypeName()
    {
        return $this->typeName;
    }

    /**
     * Set executed
     *
     * @param boolean $executed
     * @return CronObject
     */
    public function setExecuted($executed)
    {
        $this->executed = $executed;

        return $this;
    }

    /**
     * Get executed
     *
     * @return boolean 
     */
    public function getExecuted()
    {
        return $this->executed;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     * @return CronObject
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string 
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CronObject
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set runningtime
     *
     * @param integer $runningtime
     * @return CronObject
     */
    public function setRunningtime($runningtime)
    {
        $this->runningtime = $runningtime;

        return $this;
    }

    /**
     * Get runningtime
     *
     * @return integer 
     */
    public function getRunningtime()
    {
        return $this->runningtime;
    }

    /**
     * Set extraData
     *
     * @param string $extraData
     * @return CronObject
     */
    public function setExtraData($extraData)
    {
        $this->extraData = $extraData;

        return $this;
    }

    /**
     * Get extraData
     *
     * @return string 
     */
    public function getExtraData()
    {
        return $this->extraData;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return CronObject
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
