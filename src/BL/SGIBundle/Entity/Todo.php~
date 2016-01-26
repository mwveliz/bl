<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Todo
 *
 * @ORM\Table(name="todo", indexes={@ORM\Index(name="IDX_5A0EB6A0926BCFAE", columns={"id_bl"}), @ORM\Index(name="IDX_5A0EB6A0327D30B2", columns={"id_priority"}), @ORM\Index(name="IDX_5A0EB6A0F132696E", columns={"userid"})})
 * @ORM\Entity
 */
class Todo
{
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="completed", type="boolean", nullable=true)
     */
    private $completed;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="todo_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \BL\SGIBundle\Entity\FosUser
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="userid", referencedColumnName="id")
     * })
     */
    private $userid;

    /**
     * @var \BL\SGIBundle\Entity\TodoPriority
     *
     * @ORM\ManyToOne(targetEntity="BL\SGIBundle\Entity\TodoPriority")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_priority", referencedColumnName="id")
     * })
     */
    private $idPriority;

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
     * Set description
     *
     * @param string $description
     * @return Todo
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
     * Set completed
     *
     * @param boolean $completed
     * @return Todo
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean 
     */
    public function getCompleted()
    {
        return $this->completed;
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
     * @param \BL\SGIBundle\Entity\FosUser $userid
     * @return Todo
     */
    public function setUserid(\BL\SGIBundle\Entity\FosUser $userid = null)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return \BL\SGIBundle\Entity\FosUser 
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set idPriority
     *
     * @param \BL\SGIBundle\Entity\TodoPriority $idPriority
     * @return Todo
     */
    public function setIdPriority(\BL\SGIBundle\Entity\TodoPriority $idPriority = null)
    {
        $this->idPriority = $idPriority;

        return $this;
    }

    /**
     * Get idPriority
     *
     * @return \BL\SGIBundle\Entity\TodoPriority 
     */
    public function getIdPriority()
    {
        return $this->idPriority;
    }

    /**
     * Set idBl
     *
     * @param \BL\SGIBundle\Entity\Bl $idBl
     * @return Todo
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
}
