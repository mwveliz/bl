<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PipelineNode
 *
 * @ORM\Table(name="pipeline_node", indexes={@ORM\Index(name="IDX_21ACFE6A926BCFAE", columns={"id_bl"})})
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
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="pipeline_node_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\AppBundle\Entity\Bl
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\Bl")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bl", referencedColumnName="id")
     * })
     */
    private $idBl;



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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idBl
     *
     * @param \BL\AppBundle\Entity\Bl $idBl
     * @return PipelineNode
     */
    public function setIdBl(\BL\AppBundle\Entity\Bl $idBl = null)
    {
        $this->idBl = $idBl;

        return $this;
    }

    /**
     * Get idBl
     *
     * @return \BL\AppBundle\Entity\Bl 
     */
    public function getIdBl()
    {
        return $this->idBl;
    }
}
