<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 *
 * @ORM\Table(name="state", indexes={@ORM\Index(name="IDX_A393D2FB8DEE6016", columns={"id_country"})})
 * @ORM\Entity
 */
class State
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
     * @ORM\SequenceGenerator(sequenceName="state_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\Country
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_country", referencedColumnName="id")
     * })
     */
    private $idCountry;



    /**
     * Set description
     *
     * @param string $description
     * @return State
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
     * Set idCountry
     *
     * @param \BL\SGIBundle\Entity\Country $idCountry
     * @return State
     */
    public function setIdCountry(\BL\SGIBundle\Entity\Country $idCountry = null)
    {
        $this->idCountry = $idCountry;

        return $this;
    }

    /**
     * Get idCountry
     *
     * @return \BL\SGIBundle\Entity\Country 
     */
    public function getIdCountry()
    {
        return $this->idCountry;
    }
    
    
     public function __toString() {
        return $this->description;
    }     
}
