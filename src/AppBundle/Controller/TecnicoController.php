<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use AppBundle\Entity\Tecnico;
use AppBundle\Entity\Administrador;


class TecnicoController extends Controller {

	public function newAction(Request $request) {

		// Objeto tecnico
		$tecnico = new Tecnico();
		$admin = self::select_admin();
		$rol = $this->getDoctrine()->getRepository('AppBundle:Roles')->find('2');
			
		$tecnico->setIsActive(True);
		$cadena_salt = md5(uniqid(null, true));
		$tecnico->setAdministrador($admin);
		$tecnico->setSalt($cadena_salt);
		$tecnico->addRole($rol);
		
		// Creamos el formulario
		$form = $this->createFormBuilder($tecnico)
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
		->add('especialidad', 'choice', array(
				'label' => 'Especialidad',
				'choices' => array('h' => 'Hardware', 's' => 'Software'),
		))
		
		->add('save', 'submit', array('label' => 'Guardar'))
		->getForm();

		if($request->isMethod('POST')) {
			// Recogemos los datos del formulario.
			$form->handlerequest($request);

			if($form->isValid()) {
				// Codificamos el password.
				$password = $this->get('security.password_encoder')
				->encodePassword($tecnico, $tecnico->getPassword());
				$tecnico->setPassword($password);
				
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
		$admin = self::select_admin();
		$rol = $this->getDoctrine()->getRepository('AppBundle:Roles')->find('1');
		
		$tecnico->setIsActive(True);
		$cadena_salt = md5(uniqid(null, true));
		$tecnico->setSalt($cadena_salt);
		$tecnico->addRole($rol);
		
		$em = $this->getDoctrine()->getManager();
		$tecnico = $em->getRepository('AppBundle:Tecnico')->find($id);

		// Creamos el formulario
		$form = $this->createFormBuilder($tecnico)
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
				->encodePassword($tecnico, $tecnico->getPassword());
				$tecnico->setPassword($password);
				
				// Codificamos el password.
				$password = $this->get('security.password_encoder')
				->encodePassword($tecnico, $tecnico->getPassword());
				$tecnico->setPassword($password);
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
	
	/*
	 * Seleccion de administrador mediante random.
	 * */
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

}