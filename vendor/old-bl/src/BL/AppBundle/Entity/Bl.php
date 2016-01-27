<?php

namespace BL\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bl
 *
 * @ORM\Table(name="bl")
 * @ORM\Entity
 */
class Bl
{
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="code_bl", type="bigint", nullable=true)
     */
    private $codeBl;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="bl_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set type
     *
     * @param string $type
     * @return Bl
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set codeBl
     *
     * @param integer $codeBl
     * @return Bl
     */
    public function setCodeBl($codeBl)
    {
        $this->codeBl = $codeBl;

        return $this;
    }

    /**
     * Get codeBl
     *
     * @return integer 
     */
    public function getCodeBl()
    {
        return $this->codeBl;
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
