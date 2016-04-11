<?php
// src/AppBundle/Entity/Tecnico.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 * @author jaen
  * @ORM\Entity
 * @ORM\Table(name="tecnico")
 *
 */
class Tecnico extends Persona {
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
	 *
	 */
	public $especialidad;
	
	//Relación de "Administrador --- Tecnico" 1:N con la asignación de metadatos, método "Annotations".
	/**
	 * @ORM\ManyToOne(targetEntity="Administrador", inversedBy="tecnico")
	 * @ORM\JoinColumn(name="administrador_id", referencedColumnName="id", nullable=true)
	 * @Assert\NotBlank(message="val.notblank")
	 */
	protected $administrador;
	
	// Relación de "Tecnico --- Incidencias" 1:N.
	/**
	 * @ORM\OneToMany(targetEntity="Incidencia", mappedBy="tecnico")
	 */
	protected $incidencias;
	
	public function __construct()
	{
		$this->incidencias = new ArrayCollection();
	}
	
    /**
     * Set especialidad
     *
     * @param string $especialidad
     * @return Tecnico
     */
    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;

        return $this;
    }

    /**
     * Get especialidad
     *
     * @return string 
     */
    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    /**
     * Set administrador
     *
     * @param \AppBundle\Entity\Administrador $administrador
     * @return Tecnico
     */
    public function setAdministrador(\AppBundle\Entity\Administrador $administrador)
    {
        $this->administrador = $administrador;

        return $this;
    }

    /**
     * Get administrador
     *
     * @return \AppBundle\Entity\Administrador 
     */
    public function getAdministrador()
    {
        return $this->administrador;
    }

    /**
     * Add incidencias
     *
     * @param \AppBundle\Entity\Incidencia $incidencias
     * @return Tecnico
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
