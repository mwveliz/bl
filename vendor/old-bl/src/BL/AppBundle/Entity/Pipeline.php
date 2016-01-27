<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pipeline
 *
 * @ORM\Table(name="pipeline", indexes={@ORM\Index(name="IDX_7DFCD9D9351E7483", columns={"id_workflow"})})
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
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pipeline_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\AppBundle\Entity\PipelineWorkflow
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\PipelineWorkflow")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_workflow", referencedColumnName="id")
     * })
     */
    private $idWorkflow;



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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idWorkflow
     *
     * @param \BL\AppBundle\Entity\PipelineWorkflow $idWorkflow
     * @return Pipeline
     */
    public function setIdWorkflow(\BL\AppBundle\Entity\PipelineWorkflow $idWorkflow = null)
    {
        $this->idWorkflow = $idWorkflow;

        return $this;
    }

    /**
     * Get idWorkflow
     *
     * @return \BL\AppBundle\Entity\PipelineWorkflow 
     */
    public function getIdWorkflow()
    {
        return $this->idWorkflow;
    }
}
