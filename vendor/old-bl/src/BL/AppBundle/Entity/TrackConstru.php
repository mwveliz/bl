<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackConstru
 *
 * @ORM\Table(name="track_constru", indexes={@ORM\Index(name="IDX_36183481D7A9DCD4", columns={"id_bl_constru"}), @ORM\Index(name="IDX_361834814AA3EA55", columns={"id_fields_track_constru"})})
 * @ORM\Entity
 */
class TrackConstru
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
     * @ORM\SequenceGenerator(sequenceName="track_constru_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\AppBundle\Entity\FieldsTrackConstru
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\FieldsTrackConstru")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fields_track_constru", referencedColumnName="id")
     * })
     */
    private $idFieldsTrackConstru;

    /**
     * @var \BL\AppBundle\Entity\BlConstru
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\BlConstru")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bl_constru", referencedColumnName="id")
     * })
     */
    private $idBlConstru;



    /**
     * Set value
     *
     * @param string $value
     * @return TrackConstru
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
     * @return TrackConstru
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
     * Set idFieldsTrackConstru
     *
     * @param \BL\AppBundle\Entity\FieldsTrackConstru $idFieldsTrackConstru
     * @return TrackConstru
     */
    public function setIdFieldsTrackConstru(\BL\AppBundle\Entity\FieldsTrackConstru $idFieldsTrackConstru = null)
    {
        $this->idFieldsTrackConstru = $idFieldsTrackConstru;

        return $this;
    }

    /**
     * Get idFieldsTrackConstru
     *
     * @return \BL\AppBundle\Entity\FieldsTrackConstru 
     */
    public function getIdFieldsTrackConstru()
    {
        return $this->idFieldsTrackConstru;
    }

    /**
     * Set idBlConstru
     *
     * @param \BL\AppBundle\Entity\BlConstru $idBlConstru
     * @return TrackConstru
     */
    public function setIdBlConstru(\BL\AppBundle\Entity\BlConstru $idBlConstru = null)
    {
        $this->idBlConstru = $idBlConstru;

        return $this;
    }

    /**
     * Get idBlConstru
     *
     * @return \BL\AppBundle\Entity\BlConstru 
     */
    public function getIdBlConstru()
    {
        return $this->idBlConstru;
    }
}
