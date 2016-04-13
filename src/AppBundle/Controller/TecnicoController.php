<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Tecnico;
use AppBundle\Entity\Administrador;


class TecnicoController extends Controller {

	public function newAction(Request $request) {

		// Objeto tecnico
		$tecnico = new Tecnico();

		//$admin = self::search_admin();
		//$cliente->setAdministrador($admin);	// Se añade este admin aleatorio al cliente.
		
		// Creamos el formulario
		$form = $this->createFormBuilder($tecnico)
		->add('name', 'text', ['label' => 'Nombre'])
		->add('surname', 'text', ['label' => 'Apellidos'])
		->add('dni', 'text', ['label' => 'DNI'])
		->add('phone', 'integer', ['label' => 'Teléfono'])
		->add('email', 'text', ['label' => 'Email'])
		->add('address', 'text', ['label' => 'Dirección'])
		->add('especialidad', 'choice', array(
				'label' => 'Especialidad',
				'choices' => array('h' => 'Hardware', 's' => 'Software'),
		))
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
				$em->persist($tecnico);	// Persistimos
				$em->flush();			// Alamcenamos en la db
					
				$nextAction = 'user';

				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.
			}

		}

		return $this->render('Tecnico/new.html.twig', array(
				'form' => $form->createView(),
		));

	}

	public function editAction($id, Request $request) {

		// Objeto HelpDesk
		$tecnico = new Tecnico();

		$em = $this->getDoctrine()->getManager();
		$tecnico = $em->getRepository('AppBundle:Tecnico')->find($id);

		//$admin = self::search_admin();
		//$cliente->setAdministrador($admin);	// Se añade este admin aleatorio al cliente.

		// Creamos el formulario
		$form = $this->createFormBuilder($tecnico)
		->add('name', 'text', ['label' => 'Nombre'])
		->add('surname', 'text', ['label' => 'Apellidos'])
		->add('dni', 'text', ['label' => 'DNI'])
		->add('phone', 'integer', ['label' => 'Teléfono'])
		->add('email', 'text', ['label' => 'Email'])
		->add('address', 'text', ['label' => 'Dirección'])
		->add('especialidad', 'choice', array(
				'label' => 'Especialidad',
				'choices' => array('h' => 'Hardware', 's' => 'Software'),
		))
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
				$em->persist($tecnico);	// Persistimos
				$em->flush();			// Alamcenamos en la db
					
				$nextAction = 'user';

				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.
			}
		}

		return $this->render('Tecnico/new.html.twig', array(
				'form' => $form->createView(),
		));
	}

	public function deleteAction($id) {

		// Objeto administrador
		$tecnico = new Tecnico();

		$em = $this->getDoctrine()->getManager(); // Se recoge el manager
		$tecnico = $em->getRepository('AppBundle:Tecnico')->find($id);	// Buscamos en la db por id

		// Si no existe el administrador mostramos excepción
		if(!$tecnico) {
			throw $this->createNotFoundException(
					'No existe el técnico con el id '.$id );
		}

		// Se elimina el cliente y se actualiza la base de datos.
		$em->remove($tecnico);
		$em->flush();

		$nextAction = 'user';
		return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.

	}

	public function showAction($id) {

		$tecnico = $this->getDoctrine()->getRepository("AppBundle:Tecnico")->find($id);	// Buscamos en la db por id

		// Comprobamos que exista el heklpdesk.
		if (!$tecnico) {
			throw $this->createNotFoundException('No existe el técnico con el id '.$id );
		}

		//Pasar product a una plantilla.
		return $this->render('Tecnico/show.html.twig', array( 'tecnico' => $tecnico));
		
	}

}