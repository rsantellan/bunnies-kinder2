<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MdMediaIssuuVideo
 *
 * @ORM\Table(name="md_media_issuu_video")
 * @ORM\Entity
 */
class MdMediaIssuuVideo
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
     * @var string
     *
     * @ORM\Column(name="documentid", type="text", nullable=false)
     */
    private $documentid;

    /**
     * @var string
     *
     * @ORM\Column(name="embed_code", type="text", nullable=false)
     */
    private $embedCode;



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
     * Set documentid
     *
     * @param string $documentid
     * @return MdMediaIssuuVideo
     */
    public function setDocumentid($documentid)
    {
        $this->documentid = $documentid;

        return $this;
    }

    /**
     * Get documentid
     *
     * @return string 
     */
    public function getDocumentid()
    {
        return $this->documentid;
    }

    /**
     * Set embedCode
     *
     * @param string $embedCode
     * @return MdMediaIssuuVideo
     */
    public function setEmbedCode($embedCode)
    {
        $this->embedCode = $embedCode;

        return $this;
    }

    /**
     * Get embedCode
     *
     * @return string 
     */
    public function getEmbedCode()
    {
        return $this->embedCode;
    }
}
