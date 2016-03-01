<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comtrad
 *
 * @ORM\Table(name="comtrad", indexes={@ORM\Index(name="IDX_3A23F32731C3E9A0", columns={"id_type_comtrad"}), @ORM\Index(name="IDX_3A23F3274D1693CB", columns={"id_state"}), @ORM\Index(name="IDX_3A23F327E173B1B8", columns={"id_client"})})
 * @ORM\Entity
 */
class Comtrad
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
     * @ORM\SequenceGenerator(sequenceName="comtrad_id_seq", allocationSize=1, initialValue=1)
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
     * @var \BL\SGIBundle\Entity\State
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\State")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_state", referencedColumnName="id")
     * })
     */
    private $idState;

    /**
     * @var \BL\SGIBundle\Entity\TypeComtrad
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\TypeComtrad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_comtrad", referencedColumnName="id")
     * })
     */
    private $idTypeComtrad;



    /**
     * Set description
     *
     * @param string $description
     * @return Comtrad
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
     * Set idClient
     *
     * @param \BL\SGIBundle\Entity\Client $idClient
     * @return Comtrad
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
     * Set idState
     *
     * @param \BL\SGIBundle\Entity\State $idState
     * @return Comtrad
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
     * Set idTypeComtrad
     *
     * @param \BL\SGIBundle\Entity\TypeComtrad $idTypeComtrad
     * @return Comtrad
     */
    public function setIdTypeComtrad(\BL\SGIBundle\Entity\TypeComtrad $idTypeComtrad = null)
    {
        $this->idTypeComtrad = $idTypeComtrad;

        return $this;
    }

    /**
     * Get idTypeComtrad
     *
     * @return \BL\SGIBundle\Entity\TypeComtrad 
     */
    public function getIdTypeComtrad()
    {
        return $this->idTypeComtrad;
    }
     public function __toString()
	{
    return $this->description;
	}
}
