<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Twitterfollowup
 *
 * @ORM\Table(name="twitterfollowup")
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
}
