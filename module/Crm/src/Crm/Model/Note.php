<?php
namespace Crm\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Client
{
	public $id_note;
	public $id_client;
	public $note;
	
	
	protected $inputFilter;

	public function exchangeArray($data)
	{
		$this->$id_note     		= (!empty($data['$id_note'])) ? $data['$id_note'] : null;
		$this->$id_client 				= (!empty($data['$id_client'])) ? $data['$id_client'] : null;
		$this->$note				= (!empty($data['$note'])) ? $data['$note'] : null;
		
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
	
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
	
			$inputFilter->add(array(
					'name'     => '$id_note',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));
	
			$inputFilter->add(array(
					'name'     => '$id_client',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));
			$inputFilter->add(array(
					'name'     => 'note',
					'required' => true,
					'filters'  => array(
							array('name' => 'StripTags'),
							array('name' => 'StringTrim'),
					),
					'validators' => array(
							array(
									'name'    => 'StringLength',
									'options' => array(
											'encoding' => 'UTF-8',
											'min'      => 1,
											'max'      => 100,
									),
							),
					),
			));
	
			$this->inputFilter = $inputFilter;
		}
	
		return $this->inputFilter;
	}
}