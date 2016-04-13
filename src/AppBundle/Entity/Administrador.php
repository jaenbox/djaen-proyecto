<?php
// src/AppBundle/Entity/Administrador.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Administrador;
use AppBundle\Entity\Incidencia;
use AppBundle\Entity\Tecnico;


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
	
	// Relación de "Administrador --- Tecnico" 1:N.
	/**
	 * @ORM\OneToMany(targetEntity="Tecnico", mappedBy="administrador")
	 */
	protected $tecnicos;
	
	// Relación de "Administrador --- Cliente" 1:N.
	/**
	 * @ORM\OneToMany(targetEntity="Cliente", mappedBy="administrador")
	 */
	protected $clientes;
	
	public function __construct()
	{
		$this->incidencias = new ArrayCollection();
		$this->tecnicos = new ArrayCollection();
		$this->clientes = new ArrayCollection();
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

    /**
     * Add tecnicos
     *
     * @param \AppBundle\Entity\Tecnico $tecnicos
     * @return Administrador
     */
    public function addTecnico(\AppBundle\Entity\Tecnico $tecnicos)
    {

    	$this->tecnicos[] = $tecnicos;
    	return $this;
    }
    
    /**
     * Remove tecnicos
     *
     * @param \AppBundle\Entity\Tecnico $tecnicos
     */
    public function removeTecnico(\AppBundle\Entity\Tecnico $tecnicos)
    {

    	$this->tecnicos->removeElement($tecnicos);
    }
    
    /**
     * Get tecnicos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTecnicos()
    {
    	return $this->tecnicos;
    }

    /**
     * Add clientes
     *
     * @param \AppBundle\Entity\Cliente $clientes
     * @return Administrador
     */
    public function addCliente(\AppBundle\Entity\Cliente $clientes)
    {

    	$this->clientes[] = $clientes;
    	return $this;
    }
    
    /**
     * Remove clientes
     *
     * @param \AppBundle\Entity\Cliente $clientes
     */
    public function removeCliente(\AppBundle\Entity\Cliente $clientes)
    {

    	$this->clientes->removeElement($clientes);
    }
    
    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClientes()
    {
    	return $this->clientes;

        $this->clientes->removeElement($clientes);
    }

}
