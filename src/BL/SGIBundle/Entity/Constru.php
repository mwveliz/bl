<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Constru
 *
 * @ORM\Table(name="constru", indexes={@ORM\Index(name="IDX_EF86AC9C4D1693CB", columns={"id_state"}), @ORM\Index(name="IDX_EF86AC9CE173B1B8", columns={"id_client"}), @ORM\Index(name="IDX_EF86AC9CE466B61B", columns={"id_type_constru"})})
 * @ORM\Entity
 */
class Constru
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
     * @ORM\SequenceGenerator(sequenceName="constru_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\Constru
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Constru")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_constru", referencedColumnName="id")
     * })
     */
    private $idTypeConstru;

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
     * Set description
     *
     * @param string $description
     * @return Constru
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
     * Set idTypeConstru
     *
     * @param \BL\SGIBundle\Entity\Constru $idTypeConstru
     * @return Constru
     */
    public function setIdTypeConstru(\BL\SGIBundle\Entity\Constru $idTypeConstru = null)
    {
        $this->idTypeConstru = $idTypeConstru;

        return $this;
    }

    /**
     * Get idTypeConstru
     *
     * @return \BL\SGIBundle\Entity\Constru 
     */
    public function getIdTypeConstru()
    {
        return $this->idTypeConstru;
    }

    /**
     * Set idClient
     *
     * @param \BL\SGIBundle\Entity\Client $idClient
     * @return Constru
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
     * @return Constru
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
}
