<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Twitterfollowup
 *
 * @ORM\Table(name="twitterfollowup", indexes={@ORM\Index(name="IDX_A5236FD4350DF71A", columns={"id_dashboard_item"})})
 * @ORM\Entity
 */
class Twitterfollowup
{
    /**
     * @var string
     *
     * @ORM\Column(name="account", type="string", nullable=true)
     */
    private $account;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="twitterfollowup_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\DashboardItem
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\DashboardItem")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_dashboard_item", referencedColumnName="id")
     * })
     */
    private $idDashboardItem;



    /**
     * Set account
     *
     * @param string $account
     * @return Twitterfollowup
     */
    public function setAccount($account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return string 
     */
    public function getAccount()
    {
        return $this->account;
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
     * Set idDashboardItem
     *
     * @param \BL\SGIBundle\Entity\DashboardItem $idDashboardItem
     * @return Twitterfollowup
     */
    public function setIdDashboardItem(\BL\SGIBundle\Entity\DashboardItem $idDashboardItem = null)
    {
        $this->idDashboardItem = $idDashboardItem;

        return $this;
    }

    /**
     * Get idDashboardItem
     *
     * @return \BL\SGIBundle\Entity\DashboardItem 
     */
    public function getIdDashboardItem()
    {
        return $this->idDashboardItem;
    }
}
