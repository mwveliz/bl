<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackRental
 *
 * @ORM\Table(name="track_rental", indexes={@ORM\Index(name="IDX_5EDB0394E1AB4EDF", columns={"id_bl_rental"}), @ORM\Index(name="IDX_5EDB039439EA605A", columns={"id_fields_track_rental"})})
 * @ORM\Entity
 */
class TrackRental
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
     * @ORM\SequenceGenerator(sequenceName="track_rental_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\AppBundle\Entity\FieldsTrackRental
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\FieldsTrackRental")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_fields_track_rental", referencedColumnName="id")
     * })
     */
    private $idFieldsTrackRental;

    /**
     * @var \BL\AppBundle\Entity\BlRental
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\BlRental")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bl_rental", referencedColumnName="id")
     * })
     */
    private $idBlRental;



    /**
     * Set value
     *
     * @param string $value
     * @return TrackRental
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
     * @return TrackRental
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
     * Set idFieldsTrackRental
     *
     * @param \BL\AppBundle\Entity\FieldsTrackRental $idFieldsTrackRental
     * @return TrackRental
     */
    public function setIdFieldsTrackRental(\BL\AppBundle\Entity\FieldsTrackRental $idFieldsTrackRental = null)
    {
        $this->idFieldsTrackRental = $idFieldsTrackRental;

        return $this;
    }

    /**
     * Get idFieldsTrackRental
     *
     * @return \BL\AppBundle\Entity\FieldsTrackRental 
     */
    public function getIdFieldsTrackRental()
    {
        return $this->idFieldsTrackRental;
    }

    /**
     * Set idBlRental
     *
     * @param \BL\AppBundle\Entity\BlRental $idBlRental
     * @return TrackRental
     */
    public function setIdBlRental(\BL\AppBundle\Entity\BlRental $idBlRental = null)
    {
        $this->idBlRental = $idBlRental;

        return $this;
    }

    /**
     * Get idBlRental
     *
     * @return \BL\AppBundle\Entity\BlRental 
     */
    public function getIdBlRental()
    {
        return $this->idBlRental;
    }
}
