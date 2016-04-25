<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Incidencia;
use AppBundle\Entity\Administrador;
use AppBundle\Entity\Persona;
use AppBundle\Entity\Estado;
use AppBundle\Entity\Fecha_alta;
use Monolog\Logger;
use AppBundle\Entity\HelpDesk;


class IncidenciaController extends Controller {
	
	public function defaultAction(Request $request) {
		// Recogemos el repositorio
		$repository = $this->getDoctrine() ->getRepository('AppBundle:Incidencia');
		// recuperamos todos los recintos existentes
		$incidencias = $repository->findAll();	
		
		// Recogemos el repositorio
		$repository = $this->getDoctrine() ->getRepository('AppBundle:Estado');
		// recuperamos todos los recintos existentes
		$estados = $repository->findAll();
		
		// Se muestra la plantilla por defecto con el listado de incidencias.
		return $this->render('Incidencia/default.html.twig', array( 'incidencias' => $incidencias, 'estados' => $estados)); 
		
	}
	
	public function newAction(Request $request) {
		$logger = $this->get('logger');
		$logger->info(' ============= FECHA =======================');
		$logger->info(strftime( "%Y/%m/%d", time() ));
		
		// Objeto usuario
		$incidencia = new Incidencia();
		
		$admin = self::select_admin();
		$hd = self::select_helpdesk();
		$estado = self::default_estado();
		$fecha = self::get_date(); 
		
		$incidencia->setAdministrador($admin);
		$incidencia->setHelpdesk($hd);
		$incidencia->setEstado($estado); // Por defecto estado en "espera"
		$incidencia->setFechaAlta($fecha); // Fecha de la máquina
		
		// Creamos el formulario
		$form = $this->createFormBuilder($incidencia)
			->add('componente', 'text', ['label' => 'Componente'])
			->add('observaciones', 'textarea', ['label' => 'Observaciones'])
			->add('cliente', 'entity', array(
					'class' => 'AppBundle:Cliente',
					'label' => 'Cliente',
					'choice_label' => 'name'))
			/*->add('helpdesk', 'entity', array(
					'class' => 'AppBundle:HelpDesk',
					'label' => 'Help-Desk',
					'choice_label' => 'name'))*/
			/*->add('tecnico', 'entity', array(
					'class' => 'AppBundle:Tecnico',
					'label' => 'Tecnico',
					'choice_label' => 'name'))*/
			/*->add('administrador', 'entity', array(
					'class' => 'AppBundle:Administrador',
					'label' => 'Admin',
					'choice_label' => 'name'))*/			
			/*->add('estado', 'entity', array(
					'class' => 'AppBundle:Estado',
					'label' => 'Estado',
					'choice_label' => 'estado'))*/
			/*->add('fecha_alta', 'entity', array(
					'class' => 'AppBundle:Fecha_alta',
					'label' => 'Fecha Alta',					
					'choice_label' => 'name'))
			->add('fecha_cierre', 'entity', array(
					'class' => 'AppBundle:Fecha_cierre',
					'label' => 'Fecha Cierre',
					'choice_label' => 'name'))*/
						
			->add('save', 'submit', array('label' => 'Guardar'))			
			->getForm();
		
		if($request->isMethod('POST')) {
			// Recogemos los datos del formulario.
			$form->handlerequest($request);
			
			if($form->isValid()) {
				// Se almacena en la base de datos.
				$em = $this->getDoctrine()->getManager();
				$em->persist($incidencia);	// Persistimos
				$em->flush();			// Alamcenamos en la db
				
				// Se comprueba que botón se a pulsado. "save" or "saveAndAdd"
				$nextAction = 'incidencia';
				
				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction. formulario o listado.
			}
			
		}
		
		return $this->render('Incidencia/new.html.twig', array(
				'form' => $form->createView(),
		));
	}

	public function editAction($id, Request $request) {



	}

	public function deleteAction(Request $request) {



	}


	public function showAction($id) {

		$incidencia = $this->getDoctrine()->getRepository("AppBundle:Incidencia")->find($id);	// Buscamos en la db por id
		
		// Comprobamos que exista la incidencia.
		if (!$incidencia) {
			throw $this->createNotFoundException('No existe la incidencia con el id '.$id );
		}
		
		//Pasar product a una plantilla.
		return $this->render('Incidencia/show.html.twig', array( 'incidencia' => $incidencia));

	}
	
	protected function select_admin() {

			//Objeto administrador
			
			$admin = new Administrador();
			$logger = $this->get('logger');
			$logger->info(' ============= INFO SELECT ADMINISTRADOR =======================');
			
			$em = $this->getDoctrine()->getManager(); // Se recoge el manager
			$admins = $em->getRepository('AppBundle:Administrador')->findAll(); // Se recogen todos los registros de la tabla.
			$array = array();
			$valor = 0;
			$i = 0;
			// Se recogen todos los ids de los administradores existentes en la db.
			foreach($admins as $ad) {
				$array[$i] = (string)$ad->getId();
				$i++;
			}
			$i = 0;
			// Recogemos el Id mas alto existente en la db
			foreach($array as $a) {
				$max = $a;
				$i++;
				$logger->info('Contamos '.$i.' Adminsitradores encontrados');
			}
			// Se calcula por random el administrador asignado, se busca y si existe este sera el asignado, si no se repetirá el bucle.
			do {
				
				$flag = False;
				
				$valor = rand ( 1 , $max );
				$logger->info(' Random ============= '.$valor);
				$em = $this->getDoctrine()->getManager(); // Se recoge el manager
				$admin = $em->getRepository('AppBundle:Administrador')->find($valor);
				// Si existe salimos del bucle.
				if($admin) {
					$flag = True;
				}
				
			}while($flag == False);
			
			return $admin;// Devolvemos el administrador seleccionado por random.
					
	}
	
	protected function select_helpdesk() {
	
		//Objeto helpdesk			
		$helpdesk = new HelpDesk();
		
		$logger = $this->get('logger');
		$logger->info(' ============= INFO SELECT HELPDESK =======================');
			
		$em = $this->getDoctrine()->getManager(); // Se recoge el manager
		$objetos = $em->getRepository('AppBundle:HelpDesk')->findAll(); // Se recogen todos los registros de la tabla.
		$array = array();
		$valor = 0;
		$i = 0;
		// Se recogen todos los ids de los helpdesk existentes en la db.
		foreach($objetos as $ad) {
			$array[$i] = (string)$ad->getId();
			$i++;
		}
		$i = 0;
		// Recogemos el Id mas alto existente en la db
		foreach($array as $a) {
			$max = $a;
			$i++;
			$logger->info('Contamos '.$i.' Help Desk');
		}
		// Se calcula por random el helkpdesk asignado, se busca y si existe este sera el asignado, si no se repetirá el bucle.
		do {
	
			$flag = False;
	
			$valor = rand ( 1 , $max );
			$logger->info(' Random ============= '.$valor);
			$em = $this->getDoctrine()->getManager(); // Se recoge el manager
			$helpdesk = $em->getRepository('AppBundle:HelpDesk')->find($valor);
			// Si existe salimos del bucle.
			if($helpdesk) {
				$flag = True;
			}
	
		}while($flag == False);
			
		return $helpdesk;// Devolvemos el helkpdesk seleccionado por random.
				
	}
	
	protected function default_estado() {
	
		//Objeto estado
		$estado = new Estado();
	
		$logger = $this->get('logger');
		$logger->info(' ============= INFO DEFAULT ESTADO =======================');
	
		$logger->info(' Selección por defecto estado => "espera" ');
		$em = $this->getDoctrine()->getManager(); // Se recoge el manager
		$estado = $em->getRepository('AppBundle:Estado')->find(4);
			
		return $estado;// Devolvemos el estado por defecto.
	
	}
	
	protected function get_date() {
		
		$fecha = new Fecha_alta();
		$fecha_string = strftime( "%Y-%m-%d", time() );
		$fecha->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_string));
		return $fecha;
		
	}
}