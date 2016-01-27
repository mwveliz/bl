<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlComtrad
 *
 * @ORM\Table(name="bl_comtrad", indexes={@ORM\Index(name="IDX_A78603B8E4BE5A57", columns={"id_comtrad"}), @ORM\Index(name="IDX_A78603B8B5700468", columns={"id_field"}), @ORM\Index(name="IDX_A78603B84D1693CB", columns={"id_state"})})
 * @ORM\Entity
 */
class BlComtrad
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
     * @ORM\SequenceGenerator(sequenceName="bl_comtrad_id_seq", allocationSize=1, initialValue=1)
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
     * @var \BL\AppBundle\Entity\FieldsComtrad
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\FieldsComtrad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_field", referencedColumnName="id")
     * })
     */
    private $idField;

    /**
     * @var \BL\AppBundle\Entity\Comtrad
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\Comtrad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comtrad", referencedColumnName="id")
     * })
     */
    private $idComtrad;



    /**
     * Set value
     *
     * @param string $value
     * @return BlComtrad
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
     * @return BlComtrad
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
     * @param \BL\AppBundle\Entity\FieldsComtrad $idField
     * @return BlComtrad
     */
    public function setIdField(\BL\AppBundle\Entity\FieldsComtrad $idField = null)
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get idField
     *
     * @return \BL\AppBundle\Entity\FieldsComtrad 
     */
    public function getIdField()
    {
        return $this->idField;
    }

    /**
     * Set idComtrad
     *
     * @param \BL\AppBundle\Entity\Comtrad $idComtrad
     * @return BlComtrad
     */
    public function setIdComtrad(\BL\AppBundle\Entity\Comtrad $idComtrad = null)
    {
        $this->idComtrad = $idComtrad;

        return $this;
    }

    /**
     * Get idComtrad
     *
     * @return \BL\AppBundle\Entity\Comtrad 
     */
    public function getIdComtrad()
    {
        return $this->idComtrad;
    }
}
