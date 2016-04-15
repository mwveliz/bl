<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FieldsClient
 *
 * @ORM\Table(name="fields_client")
 * @ORM\Entity
 */
class FieldsClient
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
     * @ORM\Column(name="visible", type="boolean", nullable=true)
     */
    private $visible;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="fields_client_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set description
     *
     * @param string $description
     * @return FieldsClient
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
     * @return FieldsClient
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
     * Set visible
     *
     * @param boolean $visible
     * @return FieldsClient
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
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
