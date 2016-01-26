<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Alert
 *
 * @ORM\Table(name="alert", indexes={@ORM\Index(name="IDX_17FD46C1119B809F", columns={"id_log"})})
 * @ORM\Entity
 */
class Alert
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="alert_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\LogMessage
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\LogMessage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_log", referencedColumnName="id")
     * })
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
