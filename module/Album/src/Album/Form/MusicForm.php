<?php
namespace Album\Form;

use Zend\Form\Form;
class MusicForm extends Form {
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('album');
		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
		));
		$this->add(array(
				'name' => 'title',
				'type' => 'Text',
				'options' => array(
						'label' => 'Title : ',
				),
		));
		$this->add(array(
				'name' => 'artist',
				'type' => 'Text',
				'options' => array(
						'label' => 'Artist : ',
				),
		));
		$this->add(array(
				'name' => 'description',
				'type' => 'Textarea',
				'options' => array(
						'label' => 'description : ',
				),
		));
		$this->add(array(
				'name' => 'image',
				'type' => 'File',
				'options' => array(
						'label' => 'Nouvelle image : ',
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