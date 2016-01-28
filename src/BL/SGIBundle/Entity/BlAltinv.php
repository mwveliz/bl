<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlAltinv
 *
 * @ORM\Table(name="bl_altinv", indexes={@ORM\Index(name="IDX_B86C82D1B5700468", columns={"id_field"}), @ORM\Index(name="IDX_B86C82D1E9DC07B9", columns={"id_altinv"})})
 * @ORM\Entity
 */
class BlAltinv
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
     * @ORM\SequenceGenerator(sequenceName="bl_altinv_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\Altinv
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Altinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_altinv", referencedColumnName="id")
     * })
     */
    private $idAltinv;

    /**
     * @var \BL\SGIBundle\Entity\FieldsAltinv
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\FieldsAltinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_field", referencedColumnName="id")
     * })
     */
    private $idField;



    /**
     * Set value
     *
     * @param string $value
     * @return BlAltinv
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
     * Set idAltinv
     *
     * @param \BL\SGIBundle\Entity\Altinv $idAltinv
     * @return BlAltinv
     */
    public function setIdAltinv(\BL\SGIBundle\Entity\Altinv $idAltinv = null)
    {
        $this->idAltinv = $idAltinv;

        return $this;
    }

    /**
     * Get idAltinv
     *
     * @return \BL\SGIBundle\Entity\Altinv 
     */
    public function getIdAltinv()
    {
        return $this->idAltinv;
    }

    /**
     * Set idField
     *
     * @param \BL\SGIBundle\Entity\FieldsAltinv $idField
     * @return BlAltinv
     */
    public function setIdField(\BL\SGIBundle\Entity\FieldsAltinv $idField = null)
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get idField
     *
     * @return \BL\SGIBundle\Entity\FieldsAltinv 
     */
    public function getIdField()
    {
        return $this->idField;
    }
}
