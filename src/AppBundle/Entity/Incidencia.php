<?php
// src/AppBundle/Entity/Incidencia.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @author jaen
 *
 * @ORM\Entity
 * @ORM\Table(name="incidencia")
 *
 */
class Incidencia {
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
	protected $componente;
	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
	 *
	 */
	protected $observaciones;
	
	//Relación de "Cliente --- Incidencia" 1:N con la asignación de metadatos, método "Annotations".
	/**
	 * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="incidencias")
	 * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id", nullable=false)
	 */
	protected $cliente;
	
	// Relación de "Incidencia --- HelpDesk" N:1.
	/**
	 * @ORM\ManyToOne(targetEntity="HelpDesk", inversedBy="incidencias")
	 * @ORM\JoinColumn(name="helpdesk_id", referencedColumnName="id")
	 */
	protected $helpdesk;
	
	// Relación de "Incidencia --- Tecnico" N:1.
	/**
	 * @ORM\ManyToOne(targetEntity="Tecnico", inversedBy="incidencias")
	 * @ORM\JoinColumn(name="tecnico_id", referencedColumnName="id")
	 */
	protected $tecnico;
	
	// Relación de "Incidencia --- Administrador" N:1.
	/**
	 * @ORM\ManyToOne(targetEntity="Administrador", inversedBy="incidencias")
	 * @ORM\JoinColumn(name="administrador_id", referencedColumnName="id", nullable=true)
	 */
	protected $administrador;
	
	// Relación de "Incidencia --- Estado" N:1.
	/**
	 * @ORM\ManyToOne(targetEntity="Estado", inversedBy="incidencias")
	 * @ORM\JoinColumn(name="estado_id", referencedColumnName="id")
	 */
	protected $estado;
	
	// Relación de "Incidencia --- Fecha_alta" N:1.
	/**
	 * @ORM\ManyToOne(targetEntity="Fecha_alta", inversedBy="incidencias")
	 * @ORM\JoinColumn(name="fecha_alta_id", referencedColumnName="id")
	 */
	protected $fecha_alta;
	
	// Relación de "Incidencia --- Fecha_cierre" N:1.
	/**
	 * @ORM\ManyToOne(targetEntity="Fecha_cierre", inversedBy="incidencias")
	 * @ORM\JoinColumn(name="fecha_cierre_id", referencedColumnName="id")
	 */
	protected $fecha_cierre;

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
     * Set componente
     *
     * @param string $componente
     * @return Incidencia
     */
    public function setComponente($componente)
    {
        $this->componente = $componente;

        return $this;
    }

    /**
     * Get componente
     *
     * @return string 
     */
    public function getComponente()
    {
        return $this->componente;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Incidencia
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     * @return Incidencia
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \AppBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Set helpdesk
     *
     * @param \AppBundle\Entity\HelpDesk $helpdesk
     * @return Incidencia
     */
    public function setHelpdesk(\AppBundle\Entity\HelpDesk $helpdesk = null)
    {
        $this->helpdesk = $helpdesk;

        return $this;
    }

    /**
     * Get helpdesk
     *
     * @return \AppBundle\Entity\HelpDesk 
     */
    public function getHelpdesk()
    {
        return $this->helpdesk;
    }

    /**
     * Set tecnico
     *
     * @param \AppBundle\Entity\Tecnico $tecnico
     * @return Incidencia
     */
    public function setTecnico(\AppBundle\Entity\Tecnico $tecnico = null)
    {
        $this->tecnico = $tecnico;

        return $this;
    }

    /**
     * Get tecnico
     *
     * @return \AppBundle\Entity\Tecnico 
     */
    public function getTecnico()
    {
        return $this->tecnico;
    }

    /**
     * Set administrador
     *
     * @param \AppBundle\Entity\Administrador $administrador
     * @return Incidencia
     */
    public function setAdministrador(\AppBundle\Entity\Administrador $administrador = null)
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
     * Set estado
     *
     * @param \AppBundle\Entity\Estado $estado
     * @return Incidencia
     */
    public function setEstado(\AppBundle\Entity\Estado $estado = null)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return \AppBundle\Entity\Estado 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fecha_alta
     *
     * @param \AppBundle\Entity\Fecha_alta $fechaAlta
     * @return Incidencia
     */
    public function setFechaAlta(\AppBundle\Entity\Fecha_alta $fechaAlta = null)
    {
        $this->fecha_alta = $fechaAlta;

        return $this;
    }

    /**
     * Get fecha_alta
     *
     * @return \AppBundle\Entity\Fecha_alta 
     */
    public function getFechaAlta()
    {
        return $this->fecha_alta;
    }

    /**
     * Set fecha_cierre
     *
     * @param \AppBundle\Entity\Fecha_cierre $fechaCierre
     * @return Incidencia
     */
    public function setFechaCierre(\AppBundle\Entity\Fecha_cierre $fechaCierre = null)
    {
        $this->fecha_cierre = $fechaCierre;

        return $this;
    }

    /**
     * Get fecha_cierre
     *
     * @return \AppBundle\Entity\Fecha_cierre 
     */
    public function getFechaCierre()
    {
        return $this->fecha_cierre;
    }
}
