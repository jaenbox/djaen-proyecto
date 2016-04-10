<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Cliente;


class ClienteController extends Controller {

	public function defaultAction(Request $request) {
		// Recogemos el repositorio
		$repository = $this->getDoctrine() ->getRepository('AppBundle:Cliente');

		// recuperamos todos los recintos existentes
		$clientes = $repository->findAll();

		// Se muestra la plantilla por defecto con el listado de incidencias.
		return $this->render('User/default.html.twig', array( 'clientes' => $clientes));

	}

	public function newAction(Request $request) {
		
		// Objeto usuario
		$cliente = new Cliente();
		
		// Creamos el formulario
		$form = $this->createFormBuilder($cliente)
		->add('name', 'text', ['label' => 'Nombre'])
		->add('surname', 'text', ['label' => 'Apellidos'])
		->add('dni', 'text', ['label' => 'DNI'])
		->add('phone', 'integer', ['label' => 'Teléfono'])
		->add('email', 'text', ['label' => 'Email'])
		->add('address', 'text', ['label' => 'Dirección'])
		
		->add('save', 'submit', array('label' => 'Guardar'))
		->getForm();
		
		if($request->isMethod('POST')) {
			// Recogemos los datos del formulario.
			$form->handlerequest($request);
				
			if($form->isValid()) {
				// Se almacena en la base de datos.
				$em = $this->getDoctrine()->getManager();
				$em->persist($cliente);	// Persistimos
				$em->flush();			// Alamcenamos en la db
		
				// Se comprueba que botón se a pulsado. "save" or "saveAndAdd"
				$nextAction = $form->get('saveAndAdd')->isClicked()
				? 'newAction' 			// mostramos de nuevo el formulario
				: 'listCLientes';	// mostramos la lista de clientes
					
				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction. formulario o listado.
			}
				
		}
		
		return $this->render('Cliente/new.html.twig', array(
				'form' => $form->createView(),
		));
	
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