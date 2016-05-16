<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use AppBundle\Entity\Fecha_cierre;


class IncidenciaForm extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		
		$builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
			
			$incidencia = $event->getData();
			$form = $event->getForm();
			
			if( $incidencia['estado'] == 1 ) {
				$fecha = self::get_date();
				$data['fecha_cierre'] == $fecha; // Fecha de la máquina				
			}
		});		
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		
		$resolver->setDefaults(array(
				'data_class' => 'AppBundle\Entity\Incidencia'
		));
	}
	
	public function getName() {
		
		return 'Incidencia';
	}
	
	protected function get_date() {
	
		$fecha = new Fecha_cierre();
		$fecha_string = strftime( "%Y-%m-%d", time() );
		$fecha->setFecha(\DateTime::createFromFormat('Y-m-d', $fecha_string));
		return $fecha;
	
	}
		
}	