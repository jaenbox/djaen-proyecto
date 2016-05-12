<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

use AppBundle\Entity\Cliente;
use AppBundle\Entity\Administrador;
use Symfony\Component\Validator\Constraints\True;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ClienteController extends Controller {
	
	public function newAction(Request $request) {
		
		// Objeto usuario
		$cliente = new Cliente();
		$admin = self::select_admin();
		$rol = $this->getDoctrine()->getRepository('AppBundle:Roles')->find('4');
		
		$cliente->setIsActive(True);
		$cliente->setAdministrador($admin);
		$cadena_salt = md5(uniqid(null, true));
		$cliente->setAdministrador($admin);
		$cliente->setSalt($cadena_salt);
		$cliente->addRole($rol);
		
		// Creamos el formulario
		$form = $this->createFormBuilder($cliente)
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
				->encodePassword($cliente, $cliente->getPassword());
				$cliente->setPassword($password);
				
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

		// Objeto usuario
		$cliente = new Cliente();
		$admin = self::select_admin();
		$rol = $this->getDoctrine()->getRepository('AppBundle:Roles')->find('3');
		
		$cliente->setIsActive(True);
		$cliente->setAdministrador($admin);
		$cadena_salt = md5(uniqid(null, true));
		$cliente->setAdministrador($admin);
		$cliente->setSalt($cadena_salt);
		$cliente->addRole($rol);
		
		$em = $this->getDoctrine()->getManager();
		$cliente = $em->getRepository('AppBundle:Cliente')->find($id);
		
		// Creamos el formulario
		$form = $this->createFormBuilder($cliente)
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
				->encodePassword($cliente, $cliente->getPassword());
				$cliente->setPassword($password);
				
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