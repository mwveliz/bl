<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackComtrad
 *
 * @ORM\Table(name="track_comtrad", indexes={@ORM\Index(name="IDX_E3BD6B3AE4BE5A57", columns={"id_comtrad"}), @ORM\Index(name="IDX_E3BD6B3A9F06B5EE", columns={"id_fields_track_comtrad"})})
 * @ORM\Entity
 */
class TrackComtrad
{
    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", nullable=true)
     */
    private $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime", nullable=true)
     */
    private $datetime;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="track_comtrad_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\FieldsTrackComtrad
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\FieldsTrackComtrad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fields_track_comtrad", referencedColumnName="id")
     * })
     */
    private $idFieldsTrackComtrad;

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
     * Set value
     *
     * @param string $value
     * @return TrackComtrad
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
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return TrackComtrad
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime 
     */
    public function getDatetime()
    {
        return $this->datetime;
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
     * Set idFieldsTrackComtrad
     *
     * @param \BL\SGIBundle\Entity\FieldsTrackComtrad $idFieldsTrackComtrad
     * @return TrackComtrad
     */
    public function setIdFieldsTrackComtrad(\BL\SGIBundle\Entity\FieldsTrackComtrad $idFieldsTrackComtrad = null)
    {
        $this->idFieldsTrackComtrad = $idFieldsTrackComtrad;

        return $this;
    }

    /**
     * Get idFieldsTrackComtrad
     *
     * @return \BL\SGIBundle\Entity\FieldsTrackComtrad 
     */
    public function getIdFieldsTrackComtrad()
    {
        return $this->idFieldsTrackComtrad;
    }

    /**
     * Set idComtrad
     *
     * @param \BL\SGIBundle\Entity\Comtrad $idComtrad
     * @return TrackComtrad
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
}
