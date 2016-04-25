<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Estado;

class EstadoController extends Controller {
	
	public function newAction(Request $request) {
		
		// Objeto usuario
		$estado = new Estado();
		
		// Creamos el formulario
		$form = $this->createFormBuilder($estado)
		->add('estado', 'text', ['label' => 'Nombre'])
		->add('save', 'submit', array('label' => 'Guardar'))
		->getForm();
		
		if($request->isMethod('POST')) {
			// Recogemos los datos del formulario.
			$form->handlerequest($request);
				
			if($form->isValid()) {
				// Se almacena en la base de datos.
				$em = $this->getDoctrine()->getManager();
				$em->persist($estado);	// Persistimos
				$em->flush();			// Alamcenamos en la db
					
				$nextAction = 'incidencia';
				
				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.
			}
				
		}
		
		return $this->render('Estado/new.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	public function editAction($id, Request $request) {
	
		// Objeto Estado
		$estado = new Estado();
	
		$em = $this->getDoctrine()->getManager();
		$estado = $em->getRepository('AppBundle:Estado')->find($id);
	
		// Creamos el formulario
		$form = $this->createFormBuilder($estado)
		->add('estado', 'text', ['label' => 'Nombre'])	
		->add('save', 'submit', array('label' => 'Guardar'))
		->getForm();
	
		if($request->isMethod('POST')) {
			// Recogemos los datos del formulario.
			$form->handlerequest($request);
	
			if($form->isValid()) {
				// Se almacena en la base de datos.
				$em = $this->getDoctrine()->getManager();
				$em->persist($estado);	// Persistimos
				$em->flush();			// Alamcenamos en la db
					
				$nextAction = 'incidencia';
	
				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.
			}
		}
	
		return $this->render('Estado/new.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	public function deleteAction($id) {
	
		// Objeto estado
		$estado = new Estado();
	
		$em = $this->getDoctrine()->getManager(); // Se recoge el manager
		$estado = $em->getRepository('AppBundle:Estado')->find($id);	// Buscamos en la db por id
	
		// Si no existe el administrador mostramos excepción
		if(!$estado) {
			throw $this->createNotFoundException(
					'No existe el estado con el id '.$id );
		}
	
		// Se elimina el cliente y se actualiza la base de datos.
		$em->remove($estado);
		$em->flush();
	
		$nextAction = 'incidencia';
		return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.
	
	}
	
}
