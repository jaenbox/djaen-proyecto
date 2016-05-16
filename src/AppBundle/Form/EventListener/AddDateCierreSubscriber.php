<?php
namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use AppBundle\Entity\Fecha_cierre;
use Symfony\Component\Form\Form;
use AppBundle\Entity\Fecha;

class AddDateCierreSubscriber implements EventSubscriberInterface {
	
	public static function getSubscribedEvents() {
		
		return array(FormEvents::PRE_SUBMIT => array('preSubmit', 0));
	}

	/**
	 * Cuando el usuario llene los datos del formulario y haga el envío del mismo,
	 * este método será ejecutado.
	 */
	public function preSubmit(FormEvent $event)	{
		
		$data = $event->getData();
		$form = $event->getForm();
				
		if($data['estado'] == '1') {
			/*self::persistFechaCierre();*/
			$fecha = self::get_date();
			$data['fecha_cierre'] = $fecha;
			
			$form->add('fecha_cierre', 'text', array(
				'data' => $fecha
			));
		}
		
	}
	
	private function persistFechaCierre() {
		
	 	$Fecha = new Fecha();
		$fecha = self::get_date();
		$Fecha->setFecha($fecha);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($Fecha);	// Persistimos
		$em->flush();
	}
	
	private function get_date() {
	
		$fecha = new Fecha_cierre();
		$fecha_string = strftime( "%Y-%m-%d", time() );
		$fecha->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_string));
		return $fecha;
	
	}
}