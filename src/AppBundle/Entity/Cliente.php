<?php
// src/AppBundle/Entity/Cliente.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\Entity;

/**
 * 
 * @author jaen
 * @ORM\Entity
 * @ORM\Table(name="cliente")
 *
 */
class Cliente extends Persona {
	//Relación de "Administrador --- Cliente" 1:N con la asignación de metadatos, método "Annotations".
	/**
	 * @ORM\ManyToOne(targetEntity="Administrador", inversedBy="clientes")
	 * @ORM\JoinColumn(name="administrador_id", referencedColumnName="id", nullable=true)
	 * @Assert\NotBlank(message="val.notblank")
	 */
	protected $administrador;

    /**
     * Set administrador
     *
     * @param \AppBundle\Entity\Administrador $administrador
     * @return Cliente
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
}
