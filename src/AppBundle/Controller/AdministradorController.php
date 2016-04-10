<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Administrador;
use AppBundle\Entity\Persona;


class AdministradorController extends Controller {

	public function defaultAction(Request $request) {
		// Recogemos el repositorio
		$repository = $this->getDoctrine() ->getRepository('AppBundle:Administrador');

		// recuperamos todos los recintos existentes
		$admins = $repository->findAll();

		// Se muestra la plantilla por defecto con el listado de incidencias.
		return $this->render('User/default.html.twig', array( 'admins' => $admins));

	}

	public function newAction(Request $request) {

		// Objeto usuario
		$admin = new Administrador();
		
		// Creamos el formulario
		$form = $this->createFormBuilder($admin)
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
				$em->persist($admin);	// Persistimos
				$em->flush();			// Alamcenamos en la db

				// Se comprueba que botón se a pulsado. "save" or "saveAndAdd"
				$nextAction = $form->get('save')->isClicked()
				? 'user' 			// mostramos de nuevo el formulario
				: 'user';	// mostramos la lista de administradores
					
				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction. formulario o listado.
			}

		}

		return $this->render('Administrador/new.html.twig', array(
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