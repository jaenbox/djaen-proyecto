<?php
// src/AppBundle/Entity/HelpDesk.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @author jaen
 * @ORM\Entity
 * @ORM\Table(name="helpdesk")
 *
 */
class HelpDesk extends Persona {
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
	 *
	 */
	protected $idioma;
	
	//Relación de "Administrador --- HelpDesk" 1:N con la asignación de metadatos, método "Annotations".
	/**
	 * @ORM\ManyToOne(targetEntity="Administrador", inversedBy="helpdesk")
	 * @ORM\JoinColumn(name="administrador_id", referencedColumnName="id", nullable=false)
	 * @Assert\NotBlank(message="val.notblank")
	 */
	protected $administrador;
	
	// Relación de "HelpDesk --- Incidencias" 1:N.
	/**
	 * @ORM\OneToMany(targetEntity="Incidencia", mappedBy="helpdesk")
	 */
	protected $incidencias;
	
	public function __construct()
	{
		$this->incidencias = new ArrayCollection();
	}
	
    /**
     * Set idioma
     *
     * @param string $idioma
     * @return HelpDesk
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return string 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Set administrador
     *
     * @param \AppBundle\Entity\Administrador $administrador
     * @return HelpDesk
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
     * @return HelpDesk
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
