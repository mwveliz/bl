<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tenant
 *
 * @ORM\Table(name="tenant", indexes={@ORM\Index(name="IDX_4E59C462E173B1B8", columns={"id_client"})})
 * @ORM\Entity
 */
class Tenant
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tenant_id_seq", allocationSize=1, initialValue=1)
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
     * @return Tenant
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
