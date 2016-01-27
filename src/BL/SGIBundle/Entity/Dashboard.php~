<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dashboard
 *
 * @ORM\Table(name="dashboard", indexes={@ORM\Index(name="IDX_5C94FFF8943B391C", columns={"id_item"}), @ORM\Index(name="IDX_5C94FFF8F6252691", columns={"id_menu"}), @ORM\Index(name="IDX_5C94FFF816F70860", columns={"id_position"})})
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
     * @var \BL\SGIBundle\Entity\DashboardPosition
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\DashboardPosition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_position", referencedColumnName="id")
     * })
     */
    private $idPosition;

    /**
     * @var \BL\SGIBundle\Entity\Menu
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\Menu")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_menu", referencedColumnName="id")
     * })
     */
    private $idMenu;

    /**
     * @var \BL\SGIBundle\Entity\DashboardItem
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\DashboardItem")
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
     * @param \BL\SGIBundle\Entity\DashboardPosition $idPosition
     * @return Dashboard
     */
    public function setIdPosition(\BL\SGIBundle\Entity\DashboardPosition $idPosition = null)
    {
        $this->idPosition = $idPosition;

        return $this;
    }

    /**
     * Get idPosition
     *
     * @return \BL\SGIBundle\Entity\DashboardPosition 
     */
    public function getIdPosition()
    {
        return $this->idPosition;
    }

    /**
     * Set idMenu
     *
     * @param \BL\SGIBundle\Entity\Menu $idMenu
     * @return Dashboard
     */
    public function setIdMenu(\BL\SGIBundle\Entity\Menu $idMenu = null)
    {
        $this->idMenu = $idMenu;

        return $this;
    }

    /**
     * Get idMenu
     *
     * @return \BL\SGIBundle\Entity\Menu 
     */
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    /**
     * Set idItem
     *
     * @param \BL\SGIBundle\Entity\DashboardItem $idItem
     * @return Dashboard
     */
    public function setIdItem(\BL\SGIBundle\Entity\DashboardItem $idItem = null)
    {
        $this->idItem = $idItem;

        return $this;
    }

    /**
     * Get idItem
     *
     * @return \BL\SGIBundle\Entity\DashboardItem 
     */
    public function getIdItem()
    {
        return $this->idItem;
    }
}
