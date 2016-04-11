<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\Administrador;


class ClienteController extends Controller {
	/*
	public function defaultAction(Request $request) {
		// Recogemos el repositorio
		$repository = $this->getDoctrine() ->getRepository('AppBundle:Cliente');

		// recuperamos todos los recintos existentes
		$clientes = $repository->findAll();

		// Se muestra la plantilla por defecto con el listado de incidencias.
		return $this->render('User/default.html.twig', array( 'clientes' => $clientes));

	}
	*/
	public function newAction(Request $request) {
		
		// Objeto usuario
		$cliente = new Cliente();
		
		$admin = self::search_admin();
		$cliente->setAdministrador($admin);	// Se añade este admin aleatorio al cliente.
		
		// Creamos el formulario
		$form = $this->createFormBuilder($cliente)
		->add('name', 'text', ['label' => 'Nombre'])
		->add('surname', 'text', ['label' => 'Apellidos'])
		->add('dni', 'text', ['label' => 'DNI'])
		->add('phone', 'integer', ['label' => 'Teléfono'])
		->add('email', 'text', ['label' => 'Email'])
		->add('address', 'text', ['label' => 'Dirección'])
		/*->add('administrador', 'entity', array(
				'class' => 'AppBundle:Administrador',
				'label' => 'Administrador',
				'choice_label' => 'name',
		))*/
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
					
				$nextAction = 'user';
				
				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.
			}
				
		}
		
		return $this->render('Cliente/new.html.twig', array(
				'form' => $form->createView(),
		));
	
	}

	public function editAction($id, Request $request) {

		// Objeto Administrador
		$cliente = new Cliente();
		
		$em = $this->getDoctrine()->getManager();
		$cliente = $em->getRepository('AppBundle:Cliente')->find($id);
	
		//$admin = self::search_admin();
		//$cliente->setAdministrador($admin);	// Se añade este admin aleatorio al cliente.
		
		// Creamos el formulario
		$form = $this->createFormBuilder($cliente)
		->add('name', 'text', ['label' => 'Nombre'])
		->add('surname', 'text', ['label' => 'Apellidos'])
		->add('dni', 'text', ['label' => 'DNI'])
		->add('phone', 'integer', ['label' => 'Teléfono'])
		->add('email', 'text', ['label' => 'Email'])
		->add('address', 'text', ['label' => 'Dirección'])
		->add('administrador', 'entity', array(
				'class' => 'AppBundle:Administrador',
				'label' => 'Administrador',
				'choice_label' => 'name',
		))
		
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
					
				$nextAction = 'user';
		
				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.
			}
		}
		
		return $this->render('Cliente/new.html.twig', array(
				'form' => $form->createView(),
		));
	}

	public function deleteAction($id) {

		// Objeto administrador
		$cliente = new Cliente();
		
		$em = $this->getDoctrine()->getManager(); // Se recoge el manager
		$cliente = $em->getRepository('AppBundle:Cliente')->find($id);	// Buscamos en la db por id
		
		// Si no existe el administrador mostramos excepción
		if(!$cliente) {
			throw $this->createNotFoundException(
					'No existe el cliente con el id '.$id );
		}
		
		// Se elimina el cliente y se actualiza la base de datos.
		$em->remove($cliente);
		$em->flush();
		
		$nextAction = 'user';
		return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.

	}

	public function showAction($id) {
		
		$cliente = $this->getDoctrine()->getRepository("AppBundle:Cliente")->find($id);	// Buscamos en la db por id
		
		// Comprobamos que exista el administrador.
		if (!$cliente) {
			throw $this->createNotFoundException('No existe el cliente con el id '.$id );
		}
		
		//Pasar product a una plantilla.
		return $this->render('Cliente/show.html.twig', array( 'cliente' => $cliente));


	}
	
	protected function search_admin() {
		
		do {
			$flag = False;
			// Recogemos el repositorio
			$repository = $this->getDoctrine() ->getRepository('AppBundle:Administrador');
			$admins = $repository->findAll();
			$cantidad = count($admins, 1);	// Se calcular todos los admins.		
			$id = mt_rand ( 1 , $cantidad );	// Se selecciona uno al azar
			
			if($repository->find($id)){
				$flag = True;		
			}
			
		} while ($flag != True);
		
		
	}

}