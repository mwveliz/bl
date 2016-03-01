<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeRental
 *
 * @ORM\Table(name="type_rental")
 * @ORM\Entity
 */
class TypeRental
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
     * @ORM\SequenceGenerator(sequenceName="type_rental_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;



    /**
     * Set description
     *
     * @param string $description
     * @return TypeRental
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
<<<<<<< HEAD
    public function __toString()
    {
        return $this->description;
    }
=======
>>>>>>> cedd939f692c45fd89832bef17130d2238d4bcd6
}
