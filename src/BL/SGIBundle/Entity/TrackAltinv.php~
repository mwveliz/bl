<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackAltinv
 *
 * @ORM\Table(name="track_altinv", indexes={@ORM\Index(name="IDX_872973BDE9DC07B9", columns={"id_altinv"}), @ORM\Index(name="IDX_872973BDE0181073", columns={"id_fields_track_altinv"})})
 * @ORM\Entity
 */
class TrackAltinv
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
     * @ORM\SequenceGenerator(sequenceName="track_altinv_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\FieldsTrackAltinv
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\FieldsTrackAltinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fields_track_altinv", referencedColumnName="id")
     * })
     */
    private $idFieldsTrackAltinv;

    /**
     * @var \BL\SGIBundle\Entity\Altinv
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Altinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_altinv", referencedColumnName="id")
     * })
     */
    private $idAltinv;



    /**
     * Set value
     *
     * @param string $value
     * @return TrackAltinv
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
     * @return TrackAltinv
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
     * Set idFieldsTrackAltinv
     *
     * @param \BL\SGIBundle\Entity\FieldsTrackAltinv $idFieldsTrackAltinv
     * @return TrackAltinv
     */
    public function setIdFieldsTrackAltinv(\BL\SGIBundle\Entity\FieldsTrackAltinv $idFieldsTrackAltinv = null)
    {
        $this->idFieldsTrackAltinv = $idFieldsTrackAltinv;

        return $this;
    }

    /**
     * Get idFieldsTrackAltinv
     *
     * @return \BL\SGIBundle\Entity\FieldsTrackAltinv 
     */
    public function getIdFieldsTrackAltinv()
    {
        return $this->idFieldsTrackAltinv;
    }

    /**
     * Set idAltinv
     *
     * @param \BL\SGIBundle\Entity\Altinv $idAltinv
     * @return TrackAltinv
     */
    public function setIdAltinv(\BL\SGIBundle\Entity\Altinv $idAltinv = null)
    {
        $this->idAltinv = $idAltinv;

        return $this;
    }

    /**
     * Get idAltinv
     *
     * @return \BL\SGIBundle\Entity\Altinv 
     */
    public function getIdAltinv()
    {
        return $this->idAltinv;
    }
}
