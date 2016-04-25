<?php
// src/AppBundle/Entity/Persona.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

/**
 *
 * @author jaen
 *
 * @ORM\Entity
 * @ORM\Table(name="persona")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 * 		"persona" = "Persona",
 * 		"cliente" = "Cliente", 
 * 		"helpdesk" = "HelpDesk", 
 * 		"tecnico" = "Tecnico",
 * 		"administrador" = "Administrador"
 * })
 *
 */
class Persona {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 */
	protected $id;
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
	 *
	 */
	protected $name;
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
	 *
	 */
	protected $surname;
	/**
	 * @ORM\Column(type="string", length=9)
	 * @Assert\NotBlank()
	 *
	 */
	protected $dni;
	/**
	 * @ORM\Column(type="integer")
	 * @Assert\NotBlank(message="val.notblank")
	 * @Assert\Regex(
	 * 		pattern = "/\d{6}|\d{9}/",
	 * 		message = "val.phone"
	 * )
	 */
	protected $phone;
	/**
	 *
	 * @ORM\Column(type="string")
	 * @Assert\NotBlank(message="val.notblank")
	 * @Assert\Email(
	 * 		message = "val.email",
	 * 		checkMX = true
	 * )
	 */
	protected $email;
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
	 *
	 */
	protected $address;
	

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
     * Set name
     *
     * @param string $name
     * @return Persona
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
     * Set surname
     *
     * @param string $surname
     * @return Persona
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set dni
     *
     * @param string $dni
     * @return Persona
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return Persona
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Persona
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Persona
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
    
}
