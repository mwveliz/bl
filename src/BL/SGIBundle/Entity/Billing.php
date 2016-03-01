<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Billing
 *
 * @ORM\Table(name="billing", indexes={@ORM\Index(name="IDX_EC224CAA926BCFAE", columns={"id_bl"})})
 * @ORM\Entity
 */
class Billing
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_client", type="bigint", nullable=true)
     */
    private $idClient;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="billing_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\Bl
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Bl")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bl", referencedColumnName="id")
     * })
     */
    private $idBl;



    /**
     * Set idClient
     *
     * @param integer $idClient
     * @return Billing
     */
    public function setIdClient($idClient)
    {
        $this->idClient = $idClient;

        return $this;
    }

    /**
     * Get idClient
     *
     * @return integer 
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return Billing
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime 
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Billing
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idBl
     *
     * @param \BL\SGIBundle\Entity\Bl $idBl
     * @return Billing
     */
    public function setIdBl(\BL\SGIBundle\Entity\Bl $idBl = null)
    {
        $this->idBl = $idBl;

        return $this;
    }

    /**
     * Get idBl
     *
     * @return \BL\SGIBundle\Entity\Bl 
     */
    public function getIdBl()
    {
        return $this->idBl;
    }
     public function __toString()
	{
    return $this->description;
	}
}
