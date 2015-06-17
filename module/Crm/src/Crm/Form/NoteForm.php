<?php
namespace Crm\Form;

use Zend\Form\Form;

class NoteForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('note');

		$this->add(array(
				'name' => 'id_note',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'note',
				'type' => 'Text',
				'options' => array(
						'label' => 'note :',
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