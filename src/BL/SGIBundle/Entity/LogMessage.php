<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LogMessage
 *
 * @ORM\Table(name="log_message", indexes={@ORM\Index(name="IDX_8E7008E8F132696E", columns={"userid"})})
 * @ORM\Entity
 */
class LogMessage
{
    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text", nullable=true)
     */
    private $message;

    /**
     * @var string
     *
     * @ORM\Column(name="dest", type="string", nullable=true)
     */
    private $dest;

    /**
     * @var boolean
     *
     * @ORM\Column(name="instant", type="boolean", nullable=true)
     */
    private $instant;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="log_message_id_seq", allocationSize=1, initialValue=1)
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
     * Set message
     *
     * @param string $message
     * @return LogMessage
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set dest
     *
     * @param string $dest
     * @return LogMessage
     */
    public function setDest($dest)
    {
        $this->dest = $dest;

        return $this;
    }

    /**
     * Get dest
     *
     * @return string 
     */
    public function getDest()
    {
        return $this->dest;
    }

    /**
     * Set instant
     *
     * @param boolean $instant
     * @return LogMessage
     */
    public function setInstant($instant)
    {
        $this->instant = $instant;

        return $this;
    }

    /**
     * Get instant
     *
     * @return boolean 
     */
    public function getInstant()
    {
        return $this->instant;
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
     * @return LogMessage
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

 public function __toString()
	{
    return $this->description;
	}
}
