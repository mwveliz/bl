<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FieldsComtrad
 *
 * @ORM\Table(name="fields_comtrad")
 * @ORM\Entity
 */
class FieldsComtrad
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="wiget", type="string", nullable=true)
     */
    private $wiget;

    /**
     * @var boolean
     *
     * @ORM\Column(name="trackable", type="boolean", nullable=true)
     */
    private $trackable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="fields_comtrad_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set description
     *
     * @param string $description
     * @return FieldsComtrad
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
     * Set wiget
     *
     * @param string $wiget
     * @return FieldsComtrad
     */
    public function setWiget($wiget)
    {
        $this->wiget = $wiget;

        return $this;
    }

    /**
     * Get wiget
     *
     * @return string 
     */
    public function getWiget()
    {
        return $this->wiget;
    }

    /**
     * Set trackable
     *
     * @param boolean $trackable
     * @return FieldsComtrad
     */
    public function setTrackable($trackable)
    {
        $this->trackable = $trackable;

        return $this;
    }

    /**
     * Get trackable
     *
     * @return boolean 
     */
    public function getTrackable()
    {
        return $this->trackable;
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
    
     public function __toString()
	{
    return $this->description;
	}
	
}
