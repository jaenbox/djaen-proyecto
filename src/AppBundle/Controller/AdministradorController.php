<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use AppBundle\Entity\Administrador;

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

		// Objeto administrador
		$admin = new Administrador();
		$rol = $this->getDoctrine()->getRepository('AppBundle:Roles')->find('1');
		
		$admin->setIsActive(True);
		$cadena_salt = md5(uniqid(null, true));
		$admin->setSalt($cadena_salt);
		$admin->addRole($rol);
		
		// Creamos el formulario
		$form = $this->createFormBuilder($admin)
		->add('username', 'text', ['label' => 'Nombre'])
		->add('surname', 'text', ['label' => 'Apellidos'])
		->add('password', RepeatedType::class, array(
				'type' => PasswordType::class,
				'first_options'  => array('label' => 'Password'),
				'second_options' => array('label' => 'Repetir Password'),
		))
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
				// Codificamos el password.
				$password = $this->get('security.password_encoder')
				->encodePassword($admin, $admin->getPassword());
				$admin->setPassword($password);
				
				// Se almacena en la base de datos.
				$em = $this->getDoctrine()->getManager();
				$em->persist($admin);	// Persistimos
				$em->flush();			// Alamcenamos en la db

				$nextAction = 'user';
				
				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction donde se encuentran todos los usuarios.
			}

		}

		return $this->render('Administrador/new.html.twig', array(
				'form' => $form->createView(),
		));

	}

	public function editAction($id, Request $request) {
		
		// Objeto Administrador
		$admin = new Administrador();
		$rol = $this->getDoctrine()->getRepository('AppBundle:Roles')->find('1');
		
		$admin->setIsActive(True);
		$cadena_salt = md5(uniqid(null, true));
		$admin->setSalt($cadena_salt);
		$admin->addRole($rol);
		
		$em = $this->getDoctrine()->getManager();
		$admin = $em->getRepository('AppBundle:Administrador')->find($id);
		
		// Creamos el formulario
		$form = $this->createFormBuilder($admin)
		->add('username', 'text', ['label' => 'Nombre'])
		->add('surname', 'text', ['label' => 'Apellidos'])
		->add('password', RepeatedType::class, array(
				'type' => PasswordType::class,
				'first_options'  => array('label' => 'Password'),
				'second_options' => array('label' => 'Repetir Password'),
		))
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
				// Codificamos el password.
				$password = $this->get('security.password_encoder')
				->encodePassword($admin, $admin->getPassword());
				$admin->setPassword($password);
				
				// Se almacena en la base de datos.
				$em = $this->getDoctrine()->getManager();
				$em->persist($admin);	// Persistimos
				$em->flush();			// Alamcenamos en la db
		
				$nextAction = 'user';
		
				return $this->redirectToRoute($nextAction);	// Mostramos $nexAction donde se encuentran todos los usuarios.
			}
		
		}
		
		return $this->render('Administrador/new.html.twig', array(
				'form' => $form->createView(),
		));

	}

	public function deleteAction($id) {

		// Objeto administrador
		$admin = new Administrador();
		
		$em = $this->getDoctrine()->getManager(); // Se recoge el manager
		$admin = $em->getRepository('AppBundle:Administrador')->find($id);	// Buscamos en la db por id
		
		// Si no existe el administrador mostramos excepción
		if(!$admin) {
			throw $this->createNotFoundException(
					'No existe el administrador con el id '.$id );
		}
		
		// Se elimina el cliente y se actualiza la base de datos.
		$em->remove($admin);
		$em->flush();
		
		$nextAction = 'user';
		return $this->redirectToRoute($nextAction);	// Mostramos $nexAction.

	}

	public function showAction($id) {

		$admin = $this->getDoctrine()->getRepository("AppBundle:Administrador")->find($id);	// Buscamos en la db por id
		
		// Comprobamos que exista el administrador.
		if (!$admin) {
			throw $this->createNotFoundException('No existe el administrador con el id '.$id );
		}
		
		//Pasar product a una plantilla.
		return $this->render('Administrador/show.html.twig', array( 'admin' => $admin));

	}

}