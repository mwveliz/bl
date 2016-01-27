<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comtrad
 *
 * @ORM\Table(name="comtrad", indexes={@ORM\Index(name="IDX_3A23F32731C3E9A0", columns={"id_type_comtrad"})})
 * @ORM\Entity
 */
class Comtrad
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
     * @ORM\SequenceGenerator(sequenceName="comtrad_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\AppBundle\Entity\TypeComtrad
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\TypeComtrad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_type_comtrad", referencedColumnName="id")
     * })
     */
    private $idTypeComtrad;



    /**
     * Set description
     *
     * @param string $description
     * @return Comtrad
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
     * Set idTypeComtrad
     *
     * @param \BL\AppBundle\Entity\TypeComtrad $idTypeComtrad
     * @return Comtrad
     */
    public function setIdTypeComtrad(\BL\AppBundle\Entity\TypeComtrad $idTypeComtrad = null)
    {
        $this->idTypeComtrad = $idTypeComtrad;

        return $this;
    }

    /**
     * Get idTypeComtrad
     *
     * @return \BL\AppBundle\Entity\TypeComtrad 
     */
    public function getIdTypeComtrad()
    {
        return $this->idTypeComtrad;
    }
}
