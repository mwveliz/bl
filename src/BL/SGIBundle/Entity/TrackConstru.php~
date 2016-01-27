<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TrackConstru
 *
 * @ORM\Table(name="track_constru", indexes={@ORM\Index(name="IDX_36183481311B05EC", columns={"id_constru"})})
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
     * @var \BL\SGIBundle\Entity\Constru
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Constru")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_constru", referencedColumnName="id")
     * })
     */
    private $idConstru;



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
     * Set idConstru
     *
     * @param \BL\SGIBundle\Entity\Constru $idConstru
     * @return TrackConstru
     */
    public function setIdConstru(\BL\SGIBundle\Entity\Constru $idConstru = null)
    {
        $this->idConstru = $idConstru;

        return $this;
    }

    /**
     * Get idConstru
     *
     * @return \BL\SGIBundle\Entity\Constru 
     */
    public function getIdConstru()
    {
        return $this->idConstru;
    }
}
