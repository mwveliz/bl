<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Menu
 *
 * @ORM\Table(name="menu", indexes={@ORM\Index(name="IDX_7D053A93DCA143DF", columns={"id_dashboard"})})
 * @ORM\Entity
 */
class Menu
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", nullable=true)
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="menu_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\AppBundle\Entity\Dashboard
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\Dashboard")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_dashboard", referencedColumnName="id")
     * })
     */
    private $idDashboard;



    /**
     * Set description
     *
     * @param string $description
     * @return Menu
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
     * Set position
     *
     * @param string $position
     * @return Menu
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
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
     * Set idDashboard
     *
     * @param \BL\AppBundle\Entity\Dashboard $idDashboard
     * @return Menu
     */
    public function setIdDashboard(\BL\AppBundle\Entity\Dashboard $idDashboard = null)
    {
        $this->idDashboard = $idDashboard;

        return $this;
    }

    /**
     * Get idDashboard
     *
     * @return \BL\AppBundle\Entity\Dashboard 
     */
    public function getIdDashboard()
    {
        return $this->idDashboard;
    }
}
