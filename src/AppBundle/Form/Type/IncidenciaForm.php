<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\EventListener\AddDateCierreSubscriber;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class IncidenciaForm extends AbstractType {
	
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->addEventSubscriber(new AddDateCierreSubscriber());
		$builder
		->add('componente', 'text', array(
				'label' => 'Componente',
				'read_only' => true
		))
		->add('observaciones', 'textarea', array(
				'label' => 'Observaciones'
		))
		->add('cliente', 'entity', array(
				'class' => 'AppBundle:Cliente',
				'label' => 'Cliente',
				'choice_label' => 'username',
				'read_only' => true
		))
		->add('helpdesk', 'entity', array(
				'class' => 'AppBundle:HelpDesk',
				'label' => 'Help-Desk',
				'choice_label' => 'username',
				'read_only' => true
		))
		->add('tecnico', 'entity', array(
				'class' => 'AppBundle:Tecnico',
				'label' => 'Tecnico',
				'choice_label' => 'username',
				'required' => true
		))
		->add('administrador', 'entity', array(
				'class' => 'AppBundle:Administrador',
				'label' => 'Admin',
				'choice_label' => 'username',
				'read_only' => true
		))
		->add('estado', 'entity', array(
				'class' => 'AppBundle:Estado',
				'label' => 'Estado',
				'choice_label' => 'estado',
				'required' => true
		))
		->add('fecha_cierre', 'entity', array(
				'class' => 'AppBundle:Fecha_cierre',
				'label' => 'Fecha Cierre',
				'choice_label' => 'fecha',
				'required' => false,
				'read_only' => true
		))
		->add('save', 'submit', array(
				'label' => 'Guardar'
				
		));
		
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver) {
		
		$resolver->setDefaults(array(
				'data_class' => 'AppBundle\Entity\Incidencia'
		));
	}
	
	public function getName() {
		
		return 'Incidencia';
	}
}
