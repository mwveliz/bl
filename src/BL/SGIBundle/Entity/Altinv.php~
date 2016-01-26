<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Altinv
 *
 * @ORM\Table(name="altinv", indexes={@ORM\Index(name="IDX_CFEBB254E173B1B8", columns={"id_client"}), @ORM\Index(name="IDX_CFEBB2544D1693CB", columns={"id_state"}), @ORM\Index(name="IDX_CFEBB254F42E149B", columns={"id_type_altinv"})})
 * @ORM\Entity
 */
class Altinv
{
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
     * @ORM\SequenceGenerator(sequenceName="altinv_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\TypeAltinv
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\TypeAltinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_altinv", referencedColumnName="id")
     * })
     */
    private $idTypeAltinv;

    /**
     * @var \BL\SGIBundle\Entity\State
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\State")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_state", referencedColumnName="id")
     * })
     */
    private $idState;

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
     * Set description
     *
     * @param string $description
     * @return Altinv
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
     * Set idTypeAltinv
     *
     * @param \BL\SGIBundle\Entity\TypeAltinv $idTypeAltinv
     * @return Altinv
     */
    public function setIdTypeAltinv(\BL\SGIBundle\Entity\TypeAltinv $idTypeAltinv = null)
    {
        $this->idTypeAltinv = $idTypeAltinv;

        return $this;
    }

    /**
     * Get idTypeAltinv
     *
     * @return \BL\SGIBundle\Entity\TypeAltinv 
     */
    public function getIdTypeAltinv()
    {
        return $this->idTypeAltinv;
    }

    /**
     * Set idState
     *
     * @param \BL\SGIBundle\Entity\State $idState
     * @return Altinv
     */
    public function setIdState(\BL\SGIBundle\Entity\State $idState = null)
    {
        $this->idState = $idState;

        return $this;
    }

    /**
     * Get idState
     *
     * @return \BL\SGIBundle\Entity\State 
     */
    public function getIdState()
    {
        return $this->idState;
    }

    /**
     * Set idClient
     *
     * @param \BL\SGIBundle\Entity\Client $idClient
     * @return Altinv
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
    
     public function __toString() {
        return $this->description;
    }     
}
