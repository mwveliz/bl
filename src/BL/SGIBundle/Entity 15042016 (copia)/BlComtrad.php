<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlComtrad
 *
 * @ORM\Table(name="bl_comtrad", indexes={@ORM\Index(name="IDX_A78603B8B5700468", columns={"id_field"}), @ORM\Index(name="IDX_A78603B8E4BE5A57", columns={"id_comtrad"})})
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
     * @var \BL\SGIBundle\Entity\Comtrad
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Comtrad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comtrad", referencedColumnName="id")
     * })
     */
    private $idComtrad;

    /**
     * @var \BL\SGIBundle\Entity\FieldsComtrad
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\FieldsComtrad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_field", referencedColumnName="id")
     * })
     */
    private $idField;



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
     * Set idComtrad
     *
     * @param \BL\SGIBundle\Entity\Comtrad $idComtrad
     * @return BlComtrad
     */
    public function setIdComtrad(\BL\SGIBundle\Entity\Comtrad $idComtrad = null)
    {
        $this->idComtrad = $idComtrad;

        return $this;
    }

    /**
     * Get idComtrad
     *
     * @return \BL\SGIBundle\Entity\Comtrad 
     */
    public function getIdComtrad()
    {
        return $this->idComtrad;
    }

    /**
     * Set idField
     *
     * @param \BL\SGIBundle\Entity\FieldsComtrad $idField
     * @return BlComtrad
     */
    public function setIdField(\BL\SGIBundle\Entity\FieldsComtrad $idField = null)
    {
        $this->idField = $idField;

        return $this;
    }

    /**
     * Get idField
     *
     * @return \BL\SGIBundle\Entity\FieldsComtrad 
     */
    public function getIdField()
    {
        return $this->idField;
    }
}
