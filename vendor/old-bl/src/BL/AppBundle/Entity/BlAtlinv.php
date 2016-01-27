<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlAtlinv
 *
 * @ORM\Table(name="bl_atlinv", indexes={@ORM\Index(name="IDX_7D5121E2E9DC07B9", columns={"id_altinv"}), @ORM\Index(name="IDX_7D5121E2B5700468", columns={"id_field"}), @ORM\Index(name="IDX_7D5121E24D1693CB", columns={"id_state"})})
 * @ORM\Entity
 */
class BlAtlinv
{
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", nullable=true)
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bl_atlinv_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\AppBundle\Entity\State
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\State")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_state", referencedColumnName="id")
     * })
     */
    private $idState;

    /**
     * @var \BL\AppBundle\Entity\FieldsAltinv
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\FieldsAltinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_field", referencedColumnName="id")
     * })
     */
    private $idField;

    /**
     * @var \BL\AppBundle\Entity\Altinv
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\Altinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_altinv", referencedColumnName="id")
     * })
     */
    private $idAltinv;



    /**
     * Set value
     *
     * @param string $value
     * @return BlAtlinv
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
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
     * Set idState
     *
     * @param \BL\AppBundle\Entity\State $idState
     * @return BlAtlinv
     */
    public function setIdState(\BL\AppBundle\Entity\State $idState = null)
    {
        $this->idState = $idState;

        return $this;
    }

    /**
     * Get idState
     *
     * @return \BL\AppBundle\Entity\State 
     */
    public function getIdState()
    {
        return $this->idState;
    }

    /**
     * Set idField
     *
     * @param \BL\AppBundle\Entity\FieldsAltinv $idField
     * @return BlAtlinv
     */
    public function setIdField(\BL\AppBundle\Entity\FieldsAltinv $idField = null)
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get idField
     *
     * @return \BL\AppBundle\Entity\FieldsAltinv 
     */
    public function getIdField()
    {
        return $this->idField;
    }

    /**
     * Set idAltinv
     *
     * @param \BL\AppBundle\Entity\Altinv $idAltinv
     * @return BlAtlinv
     */
    public function setIdAltinv(\BL\AppBundle\Entity\Altinv $idAltinv = null)
    {
        $this->idAltinv = $idAltinv;

        return $this;
    }

    /**
     * Get idAltinv
     *
     * @return \BL\AppBundle\Entity\Altinv 
     */
    public function getIdAltinv()
    {
        return $this->idAltinv;
    }
}
