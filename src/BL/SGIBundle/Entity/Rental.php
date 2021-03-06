<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rental
 *
 * @ORM\Table(name="rental", indexes={@ORM\Index(name="IDX_1619C27D4D1693CB", columns={"id_state"}), @ORM\Index(name="IDX_1619C27DE173B1B8", columns={"id_client"}), @ORM\Index(name="IDX_1619C27D2DDC64B2", columns={"id_type_rental"})})
 * @ORM\Entity
 */
class Rental
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
     * @ORM\SequenceGenerator(sequenceName="rental_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\TypeRental
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\TypeRental")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_rental", referencedColumnName="id")
     * })
     */
    private $idTypeRental;

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
     * @return Rental
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
     * Set idTypeRental
     *
     * @param \BL\SGIBundle\Entity\TypeRental $idTypeRental
     * @return Rental
     */
    public function setIdTypeRental(\BL\SGIBundle\Entity\TypeRental $idTypeRental = null)
    {
        $this->idTypeRental = $idTypeRental;

        return $this;
    }

    /**
     * Get idTypeRental
     *
     * @return \BL\SGIBundle\Entity\TypeRental 
     */
    public function getIdTypeRental()
    {
        return $this->idTypeRental;
    }

    /**
     * Set idClient
     *
     * @param \BL\SGIBundle\Entity\Client $idClient
     * @return Rental
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
     * @return Rental
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
