<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlConstru
 *
 * @ORM\Table(name="bl_constru", indexes={@ORM\Index(name="IDX_72235C03311B05EC", columns={"id_constru"}), @ORM\Index(name="IDX_72235C03B5700468", columns={"id_field"})})
 * @ORM\Entity
 */
class BlConstru
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
     * @ORM\SequenceGenerator(sequenceName="bl_constru_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\FieldsConstru
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\FieldsConstru")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_field", referencedColumnName="id")
     * })
     */
    private $idField;

    /**
     * @var \BL\SGIBundle\Entity\Constru
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Constru")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_constru", referencedColumnName="id")
     * })
     */
    private $idConstru;



    /**
     * Set value
     *
     * @param string $value
     * @return BlConstru
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
     * @param \BL\SGIBundle\Entity\FieldsConstru $idField
     * @return BlConstru
     */
    public function setIdField(\BL\SGIBundle\Entity\FieldsConstru $idField = null)
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get idField
     *
     * @return \BL\SGIBundle\Entity\FieldsConstru 
     */
    public function getIdField()
    {
        return $this->idField;
    }

    /**
     * Set idConstru
     *
     * @param \BL\SGIBundle\Entity\Constru $idConstru
     * @return BlConstru
     */
    public function setIdConstru(\BL\SGIBundle\Entity\Constru $idConstru = null)
    {
        $this->idConstru = $idConstru;

        return $this;
    }

    /**
     * Get idConstru
     *
     * @return \BL\SGIBundle\Entity\Constru 
     */
    public function getIdConstru()
    {
        return $this->idConstru;
    }
}
