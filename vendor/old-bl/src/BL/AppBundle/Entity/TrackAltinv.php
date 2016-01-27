<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackAltinv
 *
 * @ORM\Table(name="track_altinv", indexes={@ORM\Index(name="IDX_872973BD38593EF6", columns={"id_bl_altinv"}), @ORM\Index(name="IDX_872973BDE0181073", columns={"id_fields_track_altinv"})})
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
     * @ORM\Column(name="datime", type="datetime", nullable=true)
     */
    private $datime;

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
     * @var \BL\AppBundle\Entity\FieldsTrackAltinv
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\FieldsTrackAltinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fields_track_altinv", referencedColumnName="id")
     * })
     */
    private $idFieldsTrackAltinv;

    /**
     * @var \BL\AppBundle\Entity\BlAtlinv
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\BlAtlinv")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bl_altinv", referencedColumnName="id")
     * })
     */
    private $idBlAltinv;



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
     * Set datime
     *
     * @param \DateTime $datime
     * @return TrackAltinv
     */
    public function setDatime($datime)
    {
        $this->datime = $datime;

        return $this;
    }

    /**
     * Get datime
     *
     * @return \DateTime 
     */
    public function getDatime()
    {
        return $this->datime;
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
     * @param \BL\AppBundle\Entity\FieldsTrackAltinv $idFieldsTrackAltinv
     * @return TrackAltinv
     */
    public function setIdFieldsTrackAltinv(\BL\AppBundle\Entity\FieldsTrackAltinv $idFieldsTrackAltinv = null)
    {
        $this->idFieldsTrackAltinv = $idFieldsTrackAltinv;

        return $this;
    }

    /**
     * Get idFieldsTrackAltinv
     *
     * @return \BL\AppBundle\Entity\FieldsTrackAltinv 
     */
    public function getIdFieldsTrackAltinv()
    {
        return $this->idFieldsTrackAltinv;
    }

    /**
     * Set idBlAltinv
     *
     * @param \BL\AppBundle\Entity\BlAtlinv $idBlAltinv
     * @return TrackAltinv
     */
    public function setIdBlAltinv(\BL\AppBundle\Entity\BlAtlinv $idBlAltinv = null)
    {
        $this->idBlAltinv = $idBlAltinv;

        return $this;
    }

    /**
     * Get idBlAltinv
     *
     * @return \BL\AppBundle\Entity\BlAtlinv 
     */
    public function getIdBlAltinv()
    {
        return $this->idBlAltinv;
    }
}
