<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Altinv
 *
 * @ORM\Table(name="altinv", indexes={@ORM\Index(name="IDX_CFEBB254F42E149B", columns={"id_type_altinv"})})
 * @ORM\Entity
 */
class Altinv
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
     * @ORM\SequenceGenerator(sequenceName="altinv_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\AppBundle\Entity\TypeAltinv
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\TypeAltinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_altinv", referencedColumnName="id")
     * })
     */
    private $idTypeAltinv;



    /**
     * Set description
     *
     * @param string $description
     * @return Altinv
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
     * Set idTypeAltinv
     *
     * @param \BL\AppBundle\Entity\TypeAltinv $idTypeAltinv
     * @return Altinv
     */
    public function setIdTypeAltinv(\BL\AppBundle\Entity\TypeAltinv $idTypeAltinv = null)
    {
        $this->idTypeAltinv = $idTypeAltinv;

        return $this;
    }

    /**
     * Get idTypeAltinv
     *
     * @return \BL\AppBundle\Entity\TypeAltinv 
     */
    public function getIdTypeAltinv()
    {
        return $this->idTypeAltinv;
    }
}
