<?php

namespace BL\SGIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Client
 *
 * @ORM\Table(name="client", indexes={@ORM\Index(name="IDX_C7440455F132696E", columns={"userid"})})
 * @ORM\Entity
 */
class Client
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="treatment", type="string", nullable=true)
     */
    private $treatment;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text", nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", nullable=true)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="email_one", type="string", nullable=true)
     */
    private $emailOne;

    /**
     * @var string
     *
     * @ORM\Column(name="email_two", type="string", nullable=true)
     */
    private $emailTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="legal_id", type="string", nullable=true)
     */
    private $legalId;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", nullable=true)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", nullable=true)
     */
    private $picture;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="client_id_seq", allocationSize=1, initialValue=1)
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
     * Set name
     *
     * @param string $name
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Client
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set treatment
     *
     * @param string $treatment
     * @return Client
     */
    public function setTreatment($treatment)
    {
        $this->treatment = $treatment;

        return $this;
    }

    /**
     * Get treatment
     *
     * @return string 
     */
    public function getTreatment()
    {
        return $this->treatment;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Client
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Client
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set emailOne
     *
     * @param string $emailOne
     * @return Client
     */
    public function setEmailOne($emailOne)
    {
        $this->emailOne = $emailOne;

        return $this;
    }

    /**
     * Get emailOne
     *
     * @return string 
     */
    public function getEmailOne()
    {
        return $this->emailOne;
    }

    /**
     * Set emailTwo
     *
     * @param string $emailTwo
     * @return Client
     */
    public function setEmailTwo($emailTwo)
    {
        $this->emailTwo = $emailTwo;

        return $this;
    }

    /**
     * Get emailTwo
     *
     * @return string 
     */
    public function getEmailTwo()
    {
        return $this->emailTwo;
    }

    /**
     * Set legalId
     *
     * @param string $legalId
     * @return Client
     */
    public function setLegalId($legalId)
    {
        $this->legalId = $legalId;

        return $this;
    }

    /**
     * Get legalId
     *
     * @return string 
     */
    public function getLegalId()
    {
        return $this->legalId;
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Client
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Client
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
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
     * @return Client
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
}
