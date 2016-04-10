<?php
// src/AppBundle/Entity/Administrador.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author jaen
 * @ORM\Entity
 * @ORM\Table(name="administrador")
 *
 */
class Administrador extends Persona {
	
	// Relación de "Administrador --- Incidencias" 1:N.
	/**
	 * @ORM\OneToMany(targetEntity="Incidencia", mappedBy="administrador")
	 */
	protected $incidencias;
	
	public function __construct()
	{
		$this->incidencias = new ArrayCollection();
	}

    /**
     * Add incidencias
     *
     * @param \AppBundle\Entity\Incidencia $incidencias
     * @return Administrador
     */
    public function addIncidencia(\AppBundle\Entity\Incidencia $incidencias)
    {
        $this->incidencias[] = $incidencias;

        return $this;
    }

    /**
     * Remove incidencias
     *
     * @param \AppBundle\Entity\Incidencia $incidencias
     */
    public function removeIncidencia(\AppBundle\Entity\Incidencia $incidencias)
    {
        $this->incidencias->removeElement($incidencias);
    }

    /**
     * Get incidencias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIncidencias()
    {
        return $this->incidencias;
    }
}
