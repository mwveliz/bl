<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackComtrad
 *
 * @ORM\Table(name="track_comtrad", indexes={@ORM\Index(name="IDX_E3BD6B3A20C836F", columns={"id_bl_comtrad"}), @ORM\Index(name="IDX_E3BD6B3A9F06B5EE", columns={"id_fields_track_comtrad"})})
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
     * @var \BL\AppBundle\Entity\FieldsTrackComtrad
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\FieldsTrackComtrad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fields_track_comtrad", referencedColumnName="id")
     * })
     */
    private $idFieldsTrackComtrad;

    /**
     * @var \BL\AppBundle\Entity\BlComtrad
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\BlComtrad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bl_comtrad", referencedColumnName="id")
     * })
     */
    private $idBlComtrad;



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
     * @param \BL\AppBundle\Entity\FieldsTrackComtrad $idFieldsTrackComtrad
     * @return TrackComtrad
     */
    public function setIdFieldsTrackComtrad(\BL\AppBundle\Entity\FieldsTrackComtrad $idFieldsTrackComtrad = null)
    {
        $this->idFieldsTrackComtrad = $idFieldsTrackComtrad;

        return $this;
    }

    /**
     * Get idFieldsTrackComtrad
     *
     * @return \BL\AppBundle\Entity\FieldsTrackComtrad 
     */
    public function getIdFieldsTrackComtrad()
    {
        return $this->idFieldsTrackComtrad;
    }

    /**
     * Set idBlComtrad
     *
     * @param \BL\AppBundle\Entity\BlComtrad $idBlComtrad
     * @return TrackComtrad
     */
    public function setIdBlComtrad(\BL\AppBundle\Entity\BlComtrad $idBlComtrad = null)
    {
        $this->idBlComtrad = $idBlComtrad;

        return $this;
    }

    /**
     * Get idBlComtrad
     *
     * @return \BL\AppBundle\Entity\BlComtrad 
     */
    public function getIdBlComtrad()
    {
        return $this->idBlComtrad;
    }
}
