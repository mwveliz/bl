<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlConstru
 *
 * @ORM\Table(name="bl_constru", indexes={@ORM\Index(name="IDX_72235C03311B05EC", columns={"id_constru"}), @ORM\Index(name="IDX_72235C03B5700468", columns={"id_field"}), @ORM\Index(name="IDX_72235C034D1693CB", columns={"id_state"})})
 * @ORM\Entity
 */
class BlConstru
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
     * @ORM\SequenceGenerator(sequenceName="bl_constru_id_seq", allocationSize=1, initialValue=1)
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
     * @var \BL\AppBundle\Entity\FieldsConstru
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\FieldsConstru")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_field", referencedColumnName="id")
     * })
     */
    private $idField;

    /**
     * @var \BL\AppBundle\Entity\Constru
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\Constru")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_constru", referencedColumnName="id")
     * })
     */
    private $idConstru;



    /**
     * Set value
     *
     * @param string $value
     * @return BlConstru
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
     * @return BlConstru
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
     * @param \BL\AppBundle\Entity\FieldsConstru $idField
     * @return BlConstru
     */
    public function setIdField(\BL\AppBundle\Entity\FieldsConstru $idField = null)
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get idField
     *
     * @return \BL\AppBundle\Entity\FieldsConstru 
     */
    public function getIdField()
    {
        return $this->idField;
    }

    /**
     * Set idConstru
     *
     * @param \BL\AppBundle\Entity\Constru $idConstru
     * @return BlConstru
     */
    public function setIdConstru(\BL\AppBundle\Entity\Constru $idConstru = null)
    {
        $this->idConstru = $idConstru;

        return $this;
    }

    /**
     * Get idConstru
     *
     * @return \BL\AppBundle\Entity\Constru 
     */
    public function getIdConstru()
    {
        return $this->idConstru;
    }
}
