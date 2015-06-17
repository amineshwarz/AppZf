<?php
namespace Crm\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Client
{
	public $id;
	public $nom;
	public $prenom;
	public $email;
	public $societe;
	public $telephone;
	protected $inputFilter;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->nom = (!empty($data['nom'])) ? $data['nom'] : null;
		$this->prenom  = (!empty($data['prenom'])) ? $data['prenom'] : null;
		$this->email  = (!empty($data['email'])) ? $data['email'] : null;
		$this->societe  = (!empty($data['societe'])) ? $data['societe'] : null;
		$this->telephone  = (!empty($data['telephone'])) ? $data['telephone'] : null;
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
					'name'     => 'id',
					'required' => true,
					'filters'  => array(
							array('name' => 'Int'),
					),
			));
	
			$inputFilter->add(array(
					'name'     => 'nom',
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
	
			$inputFilter->add(array(
					'name'     => 'prenom',
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
			
			$inputFilter->add(array(
					'name'     => 'email',
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
			
			$inputFilter->add(array(
					'name'     => 'societe',
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
			
			$inputFilter->add(array(
					'name'     => 'telephone',
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