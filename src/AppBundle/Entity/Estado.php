<?php
// src/AppBundle/Entity/Estado.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @author jaen
 *
 * @ORM\Entity
 * @ORM\Table(name="estado")
 *
 */
class Estado {
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
	protected $estado;

	// Relación de "Estado --- Incidencias" 1:N.
	/**
	 * @ORM\OneToMany(targetEntity="Incidencia", mappedBy="estado")
	 */
	protected $incidencias;
	
	public function __construct()
	{
		$this->incidencias = new ArrayCollection();
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
     * Set estado
     *
     * @param string $estado
     * @return Estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Add incidencias
     *
     * @param \AppBundle\Entity\Incidencia $incidencias
     * @return Estado
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
