<?php
namespace Crm\Form;

use Zend\Form\Form;

class CrmForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('client');

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'nom',
				'type' => 'Text',
				'options' => array(
						'label' => 'nom  :',
				),
		));
		$this->add(array(
				'name' => 'prenom',
				'type' => 'Text',
				'options' => array(
						'label' => 'Prenom :',
				),
		));
		$this->add(array(
				'name' => 'email',
				'type' => 'Text',
				'options' => array(
						'label' => 'E-mail :',
				),
		));
		$this->add(array(
				'name' => 'societe',
				'type' => 'Text',
				'options' => array(
						'label' => 'Societe :',
				),
		));
		$this->add(array(
				'name' => 'telephone',
				'type' => 'Text',
				'options' => array(
						'label' => 'Telephone :',
				),
		));
		$this->add(array(
				'name' => 'submit',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Go',
						'id' => 'submitbutton',
				),
		));
	}
}