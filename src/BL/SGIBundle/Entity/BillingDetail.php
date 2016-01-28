<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BillingDetail
 *
 * @ORM\Table(name="billing_detail", indexes={@ORM\Index(name="IDX_6BDC5CC332BFE5DA", columns={"id_billing"}), @ORM\Index(name="IDX_6BDC5CC3E173B1B8", columns={"id_client"})})
 * @ORM\Entity
 */
class BillingDetail
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=true)
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="billing_detail_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * @var \BL\SGIBundle\Entity\Billing
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Billing")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_billing", referencedColumnName="id")
     * })
     */
    private $idBilling;



    /**
     * Set description
     *
     * @param string $description
     * @return BillingDetail
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

    /**
     * Set value
     *
     * @param float $value
     * @return BillingDetail
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float 
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
     * Set idClient
     *
     * @param \BL\SGIBundle\Entity\Client $idClient
     * @return BillingDetail
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

    /**
     * Set idBilling
     *
     * @param \BL\SGIBundle\Entity\Billing $idBilling
     * @return BillingDetail
     */
    public function setIdBilling(\BL\SGIBundle\Entity\Billing $idBilling = null)
    {
        $this->idBilling = $idBilling;

        return $this;
    }

    /**
     * Get idBilling
     *
     * @return \BL\SGIBundle\Entity\Billing 
     */
    public function getIdBilling()
    {
        return $this->idBilling;
    }
}
