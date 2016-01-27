<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dashboard
 *
 * @ORM\Table(name="dashboard", indexes={@ORM\Index(name="IDX_5C94FFF8943B391C", columns={"id_item"}), @ORM\Index(name="IDX_5C94FFF816F70860", columns={"id_position"})})
 * @ORM\Entity
 */
class Dashboard
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="dashboard_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\AppBundle\Entity\DashboardPosition
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\DashboardPosition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_position", referencedColumnName="id")
     * })
     */
    private $idPosition;

    /**
     * @var \BL\AppBundle\Entity\DashboardItem
     *
     * @ORM\ManyToOne(targetEntity="BL\AppBundle\Entity\DashboardItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_item", referencedColumnName="id")
     * })
     */
    private $idItem;



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
     * Set idPosition
     *
     * @param \BL\AppBundle\Entity\DashboardPosition $idPosition
     * @return Dashboard
     */
    public function setIdPosition(\BL\AppBundle\Entity\DashboardPosition $idPosition = null)
    {
        $this->idPosition = $idPosition;

        return $this;
    }

    /**
     * Get idPosition
     *
     * @return \BL\AppBundle\Entity\DashboardPosition 
     */
    public function getIdPosition()
    {
        return $this->idPosition;
    }

    /**
     * Set idItem
     *
     * @param \BL\AppBundle\Entity\DashboardItem $idItem
     * @return Dashboard
     */
    public function setIdItem(\BL\AppBundle\Entity\DashboardItem $idItem = null)
    {
        $this->idItem = $idItem;

        return $this;
    }

    /**
     * Get idItem
     *
     * @return \BL\AppBundle\Entity\DashboardItem 
     */
    public function getIdItem()
    {
        return $this->idItem;
    }
}
