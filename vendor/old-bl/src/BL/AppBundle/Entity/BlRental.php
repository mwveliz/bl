<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlRental
 *
 * @ORM\Table(name="bl_rental", indexes={@ORM\Index(name="IDX_619EF2F8B5700468", columns={"id_field"}), @ORM\Index(name="IDX_619EF2F8302E7790", columns={"id_rental"}), @ORM\Index(name="IDX_619EF2F84D1693CB", columns={"id_state"}), @ORM\Index(name="IDX_619EF2F8686E718F", columns={"id_tenant"})})
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
     * @var \BL\AppBundle\Entity\Tenant
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\Tenant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tenant", referencedColumnName="id")
     * })
     */
    private $idTenant;

    /**
     * @var \BL\AppBundle\Entity\State
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\State")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_state", referencedColumnName="id")
     * })
     */
    private $idState;

    /**
     * @var \BL\AppBundle\Entity\Rental
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\Rental")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_rental", referencedColumnName="id")
     * })
     */
    private $idRental;

    /**
     * @var \BL\AppBundle\Entity\FieldsRental
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\FieldsRental")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_field", referencedColumnName="id")
     * })
     */
    private $idField;



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
     * Set idTenant
     *
     * @param \BL\AppBundle\Entity\Tenant $idTenant
     * @return BlRental
     */
    public function setIdTenant(\BL\AppBundle\Entity\Tenant $idTenant = null)
    {
        $this->idTenant = $idTenant;

        return $this;
    }

    /**
     * Get idTenant
     *
     * @return \BL\AppBundle\Entity\Tenant 
     */
    public function getIdTenant()
    {
        return $this->idTenant;
    }

    /**
     * Set idState
     *
     * @param \BL\AppBundle\Entity\State $idState
     * @return BlRental
     */
    public function setIdState(\BL\AppBundle\Entity\State $idState = null)
    {
        $this->idState = $idState;

        return $this;
    }

    /**
     * Get idState
     *
     * @return \BL\AppBundle\Entity\State 
     */
    public function getIdState()
    {
        return $this->idState;
    }

    /**
     * Set idRental
     *
     * @param \BL\AppBundle\Entity\Rental $idRental
     * @return BlRental
     */
    public function setIdRental(\BL\AppBundle\Entity\Rental $idRental = null)
    {
        $this->idRental = $idRental;

        return $this;
    }

    /**
     * Get idRental
     *
     * @return \BL\AppBundle\Entity\Rental 
     */
    public function getIdRental()
    {
        return $this->idRental;
    }

    /**
     * Set idField
     *
     * @param \BL\AppBundle\Entity\FieldsRental $idField
     * @return BlRental
     */
    public function setIdField(\BL\AppBundle\Entity\FieldsRental $idField = null)
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get idField
     *
     * @return \BL\AppBundle\Entity\FieldsRental 
     */
    public function getIdField()
    {
        return $this->idField;
    }
}
