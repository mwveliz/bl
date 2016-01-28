<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FieldsConstru
 *
 * @ORM\Table(name="fields_constru")
 * @ORM\Entity
 */
class FieldsConstru
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
     * @ORM\Column(name="widget", type="string", nullable=true)
     */
    private $widget;

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
     * @ORM\SequenceGenerator(sequenceName="fields_constru_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set description
     *
     * @param string $description
     * @return FieldsConstru
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
     * Set widget
     *
     * @param string $widget
     * @return FieldsConstru
     */
    public function setWidget($widget)
    {
        $this->widget = $widget;

        return $this;
    }

    /**
     * Get widget
     *
     * @return string 
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * Set trackable
     *
     * @param boolean $trackable
     * @return FieldsConstru
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
}
