<?php
namespace AppBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;
use AppBundle\Entity\Fecha;
use AppBundle\Entity\Fecha_cierre;

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
						
		if($data['estado'] == '1') {
			$data['fecha_cierre'] = self::get_date();
			return true;
					
		}
		return false;
	}
	
	private function get_date() {
	
		$fecha = new Fecha_cierre();
		$fecha_string = strftime( "%Y-%m-%d", time() );
		$fecha->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_string));
		return $fecha;
	
	}
}