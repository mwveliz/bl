<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event", indexes={@ORM\Index(name="IDX_3BAE0AA7926BCFAE", columns={"id_bl"}), @ORM\Index(name="IDX_3BAE0AA7F132696E", columns={"userid"})})
 * @ORM\Entity
 */
class Event
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_start", type="datetime", nullable=true)
     */
    private $datetimeStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime_end", type="datetime", nullable=true)
     */
    private $datetimeEnd;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", nullable=true)
     */
    private $place;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="event_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userid", referencedColumnName="id")
     * })
     */
    private $userid;

    /**
     * @var \BL\SGIBundle\Entity\Bl
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Bl")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_bl", referencedColumnName="id")
     * })
     */
    private $idBl;



    /**
     * Set description
     *
     * @param string $description
     * @return Event
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datetimeStart
     *
     * @param \DateTime $datetimeStart
     * @return Event
     */
    public function setDatetimeStart($datetimeStart)
    {
        $this->datetimeStart = $datetimeStart;

        return $this;
    }

    /**
     * Get datetimeStart
     *
     * @return \DateTime 
     */
    public function getDatetimeStart()
    {
        return $this->datetimeStart;
    }

    /**
     * Set datetimeEnd
     *
     * @param \DateTime $datetimeEnd
     * @return Event
     */
    public function setDatetimeEnd($datetimeEnd)
    {
        $this->datetimeEnd = $datetimeEnd;

        return $this;
    }

    /**
     * Get datetimeEnd
     *
     * @return \DateTime 
     */
    public function getDatetimeEnd()
    {
        return $this->datetimeEnd;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Event
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
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
     * Set userid
     *
     * @param \BL\SGIBundle\Entity\Usuario $userid
     * @return Event
     */
    public function setUserid(\BL\SGIBundle\Entity\Usuario $userid = null)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return \BL\SGIBundle\Entity\Usuario 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set idBl
     *
     * @param \BL\SGIBundle\Entity\Bl $idBl
     * @return Event
     */
    public function setIdBl(\BL\SGIBundle\Entity\Bl $idBl = null)
    {
        $this->idBl = $idBl;

        return $this;
    }

    /**
     * Get idBl
     *
     * @return \BL\SGIBundle\Entity\Bl 
     */
    public function getIdBl()
    {
        return $this->idBl;
    }
}
