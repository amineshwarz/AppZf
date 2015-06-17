<?php

namespace Album\Controller;

use Album\Form\AuthForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
//use Album\Form\InscriForm;

class AuthController extends AbstractActionController
{

	public function indexAction()
	{

		$form = new AuthForm();
		$form->get('submit')->setValue('Login');
		$messages = null;
		$result = null;
		$request = $this->getRequest();

		if ($request->isPost())
		{
			
			$form->setData($request->getPost());
			if ($form->isValid()) // formulaire valide
			{
				$data = $form->getData();
				$sm = $this->getServiceLocator();
				$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
				$authAdapter = new AuthAdapter($dbAdapter, 'users', 'login', 'password');

				$authAdapter->setIdentity($data['login'])->setCredential($data['password']);
				$auth = new AuthenticationService();
				// Authentication
				$auth->setAdapter($authAdapter);
				
				if ($auth->authenticate()->isValid()) // utilisateur valide
				{
					
					$columnsToOmit = array('password');
					$identity = $auth->getAdapter()->getResultRowObject(null, $columnsToOmit);
					$storage = $auth->getStorage();
					$storage->write($identity);
					$this->flashMessenger()->addSuccessMessage("Identification reussie ! ");
	
					
						return $this->redirect()->toRoute('crm', array('action' => 'index'));
				}else{ // utilisateur invalide
					$this->flashMessenger()->addErrorMessage("Erreur d'identification");
					return new ViewModel(array('form' => $form));
				}
			}else{ // formualre invalide
				return new ViewModel(array('form' => $form));
			}
		}
		else
		{
			$auth = new AuthenticationService();
			$storage = $auth->getStorage();
			if(!empty($storage->read())) // user déjà  connecté redirect to album page
				return $this->redirect()->toRoute('crm', array('action' => 'index'));
			else // pas de user connectÃ© on affiche la page de login
				return new ViewModel(array('form' => $form));
		}

		
	}
	
	public function logOutAction()
	{
		$auth = new AuthenticationService();

		if ($auth->hasIdentity()) {
			$identity = $auth->getIdentity();
		}			
		
		$auth->clearIdentity();
		$sessionManager = new \Zend\Session\SessionManager();
		$sessionManager->forgetMe();
		
		return $this->redirect()->toRoute('auth', array('action' => 'index'));	
	}
	
}