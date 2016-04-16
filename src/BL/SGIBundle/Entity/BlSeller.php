<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlSeller
 *
 * @ORM\Table(name="bl_seller", indexes={@ORM\Index(name="IDX_8C9DE379926BCFAE", columns={"id_bl"}), @ORM\Index(name="IDX_8C9DE379FCF8192D", columns={"id_usuario"})})
 * @ORM\Entity
 */
class BlSeller
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_start", type="date", nullable=true)
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_end", type="date", nullable=true)
     */
    private $dateEnd;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var float
     *
     * @ORM\Column(name="percentage", type="float", precision=10, scale=0, nullable=true)
     */
    private $percentage;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bl_seller_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

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
     * @var \BL\SGIBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
     * })
     */
    private $idUsuario;



    /**
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return BlSeller
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return BlSeller
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return BlSeller
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set percentage
     *
     * @param float $percentage
     * @return BlSeller
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return float 
     */
    public function getPercentage()
    {
        return $this->percentage;
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
     * Set idBl
     *
     * @param \BL\SGIBundle\Entity\Bl $idBl
     * @return BlSeller
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

    /**
     * Set idUsuario
     *
     * @param \BL\SGIBundle\Entity\Usuario $idUsuario
     * @return BlSeller
     */
    public function setIdUsuario(\BL\SGIBundle\Entity\Usuario $idUsuario = null)
    {
        $this->idUsuario = $idUsuario;

        return $this;
    }

    /**
     * Get idUsuario
     *
     * @return \BL\SGIBundle\Entity\Usuario 
     */
    public function getIdUsuario()
    {
        return $this->idUsuario;
    }
}
