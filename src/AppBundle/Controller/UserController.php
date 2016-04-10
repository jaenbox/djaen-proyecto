<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Cliente;


class UserController extends Controller {
	
	public function defaultAction(Request $request) {
		// Recogemos el repositorio
		$repository = $this->getDoctrine() ->getRepository('AppBundle:Cliente');
	
		// recuperamos todos los recintos existentes
		$usuarios = $repository->findAll();
	
		// Se muestra la plantilla por defecto con el listado de incidencias.
		return $this->render('User/default.html.twig', array( 'usuarios' => $usuarios));
	
	}
	
	public function newAction(Request $request) {
		
		// Objeto usuario
		$cliente = new Cliente();
		
		
	}
	
	public function editAction($id, Request $request) {
	
		
	
	}
	
	public function deleteAction(Request $request) {
	
		
	
	}
	
	public function listAction(Request $request) {
	
	
	
	}
	
	public function showAction(Request $request) {
	
	
	
	}
	
}