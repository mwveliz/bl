<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PipelineWorkflow
 *
 * @ORM\Table(name="pipeline_workflow")
 * @ORM\Entity
 */
class PipelineWorkflow
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_parent_node", type="bigint", nullable=true)
     */
    private $idParentNode;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_child_node", type="bigint", nullable=true)
     */
    private $idChildNode;

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
     * @ORM\SequenceGenerator(sequenceName="pipeline_workflow_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set idParentNode
     *
     * @param integer $idParentNode
     * @return PipelineWorkflow
     */
    public function setIdParentNode($idParentNode)
    {
        $this->idParentNode = $idParentNode;

        return $this;
    }

    /**
     * Get idParentNode
     *
     * @return integer 
     */
    public function getIdParentNode()
    {
        return $this->idParentNode;
    }

    /**
     * Set idChildNode
     *
     * @param integer $idChildNode
     * @return PipelineWorkflow
     */
    public function setIdChildNode($idChildNode)
    {
        $this->idChildNode = $idChildNode;

        return $this;
    }

    /**
     * Get idChildNode
     *
     * @return integer 
     */
    public function getIdChildNode()
    {
        return $this->idChildNode;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return PipelineWorkflow
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

public function __toString()
	{
    return $this->description;
	}
}