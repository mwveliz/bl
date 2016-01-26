<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alert
 */
class Alert
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\LogMessage
     */
    private $idLog;


    /**
     * Set description
     *
     * @param string $description
     * @return Alert
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idLog
     *
     * @param \BL\SGIBundle\Entity\LogMessage $idLog
     * @return Alert
     */
    public function setIdLog(\BL\SGIBundle\Entity\LogMessage $idLog = null)
    {
        $this->idLog = $idLog;

        return $this;
    }

    /**
     * Get idLog
     *
     * @return \BL\SGIBundle\Entity\LogMessage 
     */
    public function getIdLog()
    {
        return $this->idLog;
    }
}
