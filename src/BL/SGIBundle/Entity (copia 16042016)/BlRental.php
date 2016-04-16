<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlRental
 *
 * @ORM\Table(name="bl_rental", indexes={@ORM\Index(name="IDX_619EF2F8302E7790", columns={"id_rental"}), @ORM\Index(name="IDX_619EF2F8B5700468", columns={"id_field"})})
 * @ORM\Entity
 */
class BlRental
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
     * @ORM\SequenceGenerator(sequenceName="bl_rental_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\FieldsRental
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\FieldsRental")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_field", referencedColumnName="id")
     * })
     */
    private $idField;

    /**
     * @var \BL\SGIBundle\Entity\Rental
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Rental")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rental", referencedColumnName="id")
     * })
     */
    private $idRental;



    /**
     * Set value
     *
     * @param string $value
     * @return BlRental
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
     * @param \BL\SGIBundle\Entity\FieldsRental $idField
     * @return BlRental
     */
    public function setIdField(\BL\SGIBundle\Entity\FieldsRental $idField = null)
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get idField
     *
     * @return \BL\SGIBundle\Entity\FieldsRental 
     */
    public function getIdField()
    {
        return $this->idField;
    }

    /**
     * Set idRental
     *
     * @param \BL\SGIBundle\Entity\Rental $idRental
     * @return BlRental
     */
    public function setIdRental(\BL\SGIBundle\Entity\Rental $idRental = null)
    {
        $this->idRental = $idRental;

        return $this;
    }

    /**
     * Get idRental
     *
     * @return \BL\SGIBundle\Entity\Rental 
     */
    public function getIdRental()
    {
        return $this->idRental;
    }
}
