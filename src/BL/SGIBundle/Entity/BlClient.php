<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlClient
 *
 * @ORM\Table(name="bl_client", indexes={@ORM\Index(name="IDX_B0C334D0B5700468", columns={"id_field"}), @ORM\Index(name="IDX_B0C334D0E173B1B8", columns={"id_client"})})
 * @ORM\Entity
 */
class BlClient
{
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", nullable=true)
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bl_client_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\FieldsClient
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\FieldsClient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_field", referencedColumnName="id")
     * })
     */
    private $idField;

    /**
     * @var \BL\SGIBundle\Entity\Client
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Client")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $idClient;



    /**
     * Set value
     *
     * @param string $value
     * @return BlClient
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

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
     * Set idField
     *
     * @param \BL\SGIBundle\Entity\FieldsClient $idField
     * @return BlClient
     */
    public function setIdField(\BL\SGIBundle\Entity\FieldsClient $idField = null)
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get idField
     *
     * @return \BL\SGIBundle\Entity\FieldsClient 
     */
    public function getIdField()
    {
        return $this->idField;
    }

    /**
     * Set idClient
     *
     * @param \BL\SGIBundle\Entity\Client $idClient
     * @return BlClient
     */
    public function setIdClient(\BL\SGIBundle\Entity\Client $idClient = null)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get idClient
     *
     * @return \BL\SGIBundle\Entity\Client 
     */
    public function getIdClient()
    {
        return $this->idClient;
    }
}
