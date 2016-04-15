<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pipeline
 *
 * @ORM\Table(name="pipeline")
 * @ORM\Entity
 */
class Pipeline
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
     * @ORM\Column(name="id_bl", type="bigint", nullable=true)
     */
    private $idBl;

    /**
     * @var json
     *
     * @ORM\Column(name="node", type="json", nullable=true)
     */
    private $node;

    /**
     * @var json
     *
     * @ORM\Column(name="edge", type="json", nullable=true)
     */
    private $edge;

    /**
     * @var json
     *
     * @ORM\Column(name="port", type="json", nullable=true)
     */
    private $port;

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
     * @ORM\SequenceGenerator(sequenceName="pipeline_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set description
     *
     * @param string $description
     * @return Pipeline
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
     * Set idBl
     *
     * @param integer $idBl
     * @return Pipeline
     */
    public function setIdBl($idBl)
    {
        $this->idBl = $idBl;

        return $this;
    }

    /**
     * Get idBl
     *
     * @return integer 
     */
    public function getIdBl()
    {
        return $this->idBl;
    }

    /**
     * Set node
     *
     * @param json $node
     * @return Pipeline
     */
    public function setNode($node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Get node
     *
     * @return json 
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * Set edge
     *
     * @param json $edge
     * @return Pipeline
     */
    public function setEdge($edge)
    {
        $this->edge = $edge;

        return $this;
    }

    /**
     * Get edge
     *
     * @return json 
     */
    public function getEdge()
    {
        return $this->edge;
    }

    /**
     * Set port
     *
     * @param json $port
     * @return Pipeline
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return json 
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set visible
     *
     * @param boolean $visible
     * @return Pipeline
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
