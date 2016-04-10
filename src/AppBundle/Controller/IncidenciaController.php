<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Incidencia;


class IncidenciaController extends Controller {
	
	public function defaultAction(Request $request) {
		// Recogemos el repositorio
		$repository = $this->getDoctrine() ->getRepository('AppBundle:Incidencia');
		
		// recuperamos todos los recintos existentes
		$incidencias = $repository->findAll();	
				
		// Se muestra la plantilla por defecto con el listado de incidencias.
		return $this->render('Incidencia/default.html.twig', array( 'incidencias' => $incidencias)); 
		
	}
	
	public function newAction(Request $request) {

		// Objeto usuario
		$incidencia = new Incidencia();
		
		// Creamos el formulario
		$form = $this->createFormBuilder($incidencia)
			->add('componente', 'text', ['label' => 'Componente'])
			->add('observaciones', 'text', ['label' => 'Observaciones'])
			->add('cliente', 'entity', array(
					'class' => 'AppBundle:Cliente',
					'label' => 'Cliente',
					'choice_label' => 'name'))
			->add('helpdesk', 'entity', array(
					'class' => 'AppBundle:HelpDesk',
					'label' => 'Help-Desk',
					'choice_label' => 'name'))
			->add('tecnico', 'entity', array(
					'class' => 'AppBundle:Tecnico',
					'label' => 'Tecnico',
					'choice_label' => 'name'))
			->add('administrador', 'entity', array(
					'class' => 'AppBundle:Administrador',
					'label' => 'Admin',
					'choice_label' => 'name'))
			->add('estado', 'entity', array(
					'class' => 'AppBundle:Estado',
					'label' => 'Estado',
					'choice_label' => 'name'))
			->add('fecha_alta', 'entity', array(
					'class' => 'AppBundle:Fecha_alta',
					'label' => 'Fecha Alta',
					'choice_label' => 'name'))
			->add('fecha_cierre', 'entity', array(
					'class' => 'AppBundle:Fecha_cierre',
					'label' => 'Fecha Cierre',
					'choice_label' => 'name'))
						
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
				$nextAction = $form->get('saveAndAdd')->isClicked()
				? 'newAction' 			// mostramos de nuevo el formulario
				: 'listIncidencias';	// mostramos la lista de incidencias
					
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


	public function showAction(Request $request) {



	}

}