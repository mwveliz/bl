<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PipelineNode
 *
 * @ORM\Table(name="pipeline_node", indexes={@ORM\Index(name="IDX_21ACFE6A2D27354C", columns={"id_pipeline"})})
 * @ORM\Entity
 */
class PipelineNode
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_node", type="date", nullable=true)
     */
    private $dateNode;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="percentage_completion", type="string", nullable=true)
     */
    private $percentageCompletion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pipeline_node_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\PipelineNode
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\PipelineNode")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_pipeline", referencedColumnName="id")
     * })
     */
    private $idPipeline;



    /**
     * Set description
     *
     * @param string $description
     * @return PipelineNode
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
     * Set dateNode
     *
     * @param \DateTime $dateNode
     * @return PipelineNode
     */
    public function setDateNode($dateNode)
    {
        $this->dateNode = $dateNode;

        return $this;
    }

    /**
     * Get dateNode
     *
     * @return \DateTime 
     */
    public function getDateNode()
    {
        return $this->dateNode;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return PipelineNode
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set percentageCompletion
     *
     * @param string $percentageCompletion
     * @return PipelineNode
     */
    public function setPercentageCompletion($percentageCompletion)
    {
        $this->percentageCompletion = $percentageCompletion;

        return $this;
    }

    /**
     * Get percentageCompletion
     *
     * @return string 
     */
    public function getPercentageCompletion()
    {
        return $this->percentageCompletion;
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
     * Set idPipeline
     *
     * @param \BL\SGIBundle\Entity\PipelineNode $idPipeline
     * @return PipelineNode
     */
    public function setIdPipeline(\BL\SGIBundle\Entity\PipelineNode $idPipeline = null)
    {
        $this->idPipeline = $idPipeline;

        return $this;
    }

    /**
     * Get idPipeline
     *
     * @return \BL\SGIBundle\Entity\PipelineNode 
     */
    public function getIdPipeline()
    {
        return $this->idPipeline;
    }
}
