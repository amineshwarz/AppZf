<?php
namespace Crm\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Crm\Model\client;       
use Crm\Form\CrmForm;       

class CrmController extends AbstractActionController
{
	
	protected $clientTable;
	
	public function indexAction()
	{
		return new ViewModel(array( 'clients' => $this->getClientTable()->fetchAll(), ));
	}

	public function addAction()
	{
		$form = new CrmForm();
		$form->get('submit')->setValue('Add');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$client = new client();
			$form->setInputFilter($client->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$client->exchangeArray($form->getData());
				$this->getClientTable()->saveClient($client);
		
				// Redirect to list of albums
				return $this->redirect()->toRoute('crm');
			}
		}
		return array('form' => $form);
	}

	public function editAction()
	{
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('crm', array(
					'action' => 'add'
			));
		}
		
		// Get the Album with the specified id.  An exception is thrown
		// if it cannot be found, in which case go to the index page.
		try {
			$client = $this->getClientTable()->getClient($id);
		}
		catch (\Exception $ex) {
			return $this->redirect()->toRoute('crm', array(
					'action' => 'index'
			));
		}
		
		$form  = new CrmForm();
		$form->bind($client);
		$form->get('submit')->setAttribute('value', 'Edit');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($client->getInputFilter());
			$form->setData($request->getPost());
		
			if ($form->isValid()) {
				$this->getClientTable()->saveClient($client);
		
				// Redirect to list of albums
				return $this->redirect()->toRoute('crm');
			}
		}
		
		return array(
				'id' => $id,
				'form' => $form,
		);
	}

	public function deleteAction()
	{
		
			$id = (int) $this->params()->fromRoute('id', 0);
			if (!$id) {
				return $this->redirect()->toRoute('crm');
			}
		
			$request = $this->getRequest();
			if ($request->isPost()) {
				$del = $request->getPost('del', 'No');
		
				if ($del == 'Yes') {
					$id = (int) $request->getPost('id');
					$this->getClientTable()->deleteClient($id);
				}
		
				// Redirect to list of albums
				return $this->redirect()->toRoute('crm');
			}
		
			return array(
					'id'    => $id,
					'crm' => $this->getClientTable()->getClient($id)
			);
	}
	
	public function getClientTable()
	{
		if (!$this->clientTable) {
			$sm = $this->getServiceLocator();
			$this->clientTable = $sm->get('Crm\Model\ClientTable');
		}
		return $this->clientTable;
	}
}