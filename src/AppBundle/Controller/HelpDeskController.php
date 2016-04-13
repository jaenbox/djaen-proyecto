<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\HelpDesk;
use AppBundle\Entity\Administrador;


class HelpDeskController extends Controller {

	public function newAction(Request $request) {

		// Objeto usuario
		$helpdesk = new HelpDesk();

		//$admin = self::search_admin();
		//$cliente->setAdministrador($admin);	// Se añade este admin aleatorio al cliente.
		// Array de idiomas disponibles.
		$idiomas = array(
				'idioma' => array(
						'spa' => 'Castellano',
						'en' => 'Inglés',
						'vlc' => 'Valencià'),
		);
		// Creamos el formulario
		$form = $this->createFormBuilder($helpdesk)
		->add('name', 'text', ['label' => 'Nombre'])
		->add('surname', 'text', ['label' => 'Apellidos'])
		->add('dni', 'text', ['label' => 'DNI'])
		->add('phone', 'integer', ['label' => 'Teléfono'])
		->add('email', 'text', ['label' => 'Email'])
		->add('address', 'text', ['label' => 'Dirección'])
		->add('idioma', 'choice', array(
				'label' => 'Idioma',				
				'required' => false,
				'multiple' => true,
				'expanded' => true,
				'choices' => $idiomas,
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
				$em->persist($helpdesk);	// Persistimos
				$em->flush();			// Alamcenamos en la db
					
				$nextAction = 'user';

				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.
			}

		}

		return $this->render('HelpDesk/new.html.twig', array(
				'form' => $form->createView(),
		));

	}

	public function editAction($id, Request $request) {

		// Objeto HelpDesk
		$helpdesk = new HelpDesk();

		$em = $this->getDoctrine()->getManager();
		$helpdesk = $em->getRepository('AppBundle:HelpDesk')->find($id);

		//$admin = self::search_admin();
		//$cliente->setAdministrador($admin);	// Se añade este admin aleatorio al cliente.
		// Array de idiomas disponibles. 
		$idiomas = array(
				'idioma' => array(
						'spa' => 'Castellano', 
						'en' => 'Inglés', 
						'vlc' => 'Valencià'),
				);
		// Creamos el formulario
		$form = $this->createFormBuilder($helpdesk)
		->add('name', 'text', ['label' => 'Nombre'])
		->add('surname', 'text', ['label' => 'Apellidos'])
		->add('dni', 'text', ['label' => 'DNI'])
		->add('phone', 'integer', ['label' => 'Teléfono'])
		->add('email', 'text', ['label' => 'Email'])
		->add('address', 'text', ['label' => 'Dirección'])
		->add('idioma', 'choice', array(
				'label' => 'Idioma',
				'required' => false,
				'multiple' => true,
				'expanded' => true,
				'choices' => $idiomas
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
				$em->persist($helpdesk);	// Persistimos
				$em->flush();			// Alamcenamos en la db
					
				$nextAction = 'user';

				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.
			}
		}

		return $this->render('HelpDesk/new.html.twig', array(
				'form' => $form->createView(),
		));
	}

	public function deleteAction($id) {

		// Objeto administrador
		$helpdesk = new HelpDesk();

		$em = $this->getDoctrine()->getManager(); // Se recoge el manager
		$helpdesk = $em->getRepository('AppBundle:HelpDesk')->find($id);	// Buscamos en la db por id

		// Si no existe el administrador mostramos excepción
		if(!$helpdesk) {
			throw $this->createNotFoundException(
					'No existe el helpdesk con el id '.$id );
		}

		// Se elimina el cliente y se actualiza la base de datos.
		$em->remove($helpdesk);
		$em->flush();

		$nextAction = 'user';
		return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.

	}

	public function showAction($id) {

		$helpdesk = $this->getDoctrine()->getRepository("AppBundle:HelpDesk")->find($id);	// Buscamos en la db por id

		// Comprobamos que exista el heklpdesk.
		if (!$helpdesk) {
			throw $this->createNotFoundException('No existe el helpdesk con el id '.$id );
		}

		//Pasar product a una plantilla.
		return $this->render('HelpDesk/show.html.twig', array( 'helpdesk' => $helpdesk));
		
	}

}