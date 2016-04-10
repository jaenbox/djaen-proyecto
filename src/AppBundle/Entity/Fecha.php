<?php
// src/AppBundle/Entity/Fecha.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;

/**
 *
 * @author jaen
 * 
 * @ORM\Entity
 * @ORM\Table(name="fecha")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 * 		"fechaalta" = "Fecha_alta",
 * 		"fechacierre" = "Fecha_cierre"
 * })
 *
 */
class Fecha {
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="date")
	 * @Assert\Date(message="val.date")
	 * @Assert\NotBlank(message="val.notblank")
	 */
	protected $fecha;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }
}
