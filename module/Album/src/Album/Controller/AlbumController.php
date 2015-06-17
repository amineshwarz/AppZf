<?php

namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Album\Model\Album;
use Album\Form\AlbumForm;
use Album\Form\FormMusic;
use zend\Db\sql\Sql;
use Zend\Db\TableGateway\TableGateway;
use Album\Acl\AclManage;
use Album\Form\ChansonForm;
use Album\Form\MusicForm;

class AlbumController extends AbstractActionController
{
	protected $albumTable;
	
	public function indexAction()
	{
		return new ViewModel(array(
             'albums' => $this->getAlbumTable()->fetchAll(),
         ));
	}
	


	public function addAction()
	{
		
		$sm=$this->getServiceLocator();
		$auth=$sm->get("AuthenticationService");
		if ($auth->hasIdentity()){ //si il est co
			$identity= $auth->getIdentity();
			$role= $identity->role;
			$acl=$sm->get("AclManage");
		}else { //sinn redirect page auth
			$this->flashMessenger()->addWarningMessage("connecter vous SVP pour ajouter un album");
			return $this->redirect()->toRoute('auth',array('action'=>'index'));
		}
		
		if (!$acl->isAllowed($role,__METHOD__)){  //si l'user co n'a pas le droit
			
			$this->flashMessenger()->addWarningMessage("desoler vous ne pouvez pas");
			return $this->redirect()->toRoute('album',array('action'=>'noprivilege'));
		}
		
		
		
		$form = new AlbumForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $album = new Album();
             $form->setInputFilter($album->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $album->exchangeArray($form->getData());
                 $this->getAlbumTable()->saveAlbum($album);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('album');
             }
         }
         return array('form' => $form);
	}

	
	
	public function editAction()
	{
		$sm=$this->getServiceLocator();
		$auth=$sm->get("AuthenticationService");
		if ($auth->hasIdentity()){ //si il est co
			$identity= $auth->getIdentity();
			$role= $identity->role;
			$acl=$sm->get("AclManage");
		}else { //sinn redirect page auth
			$this->flashMessenger()->addWarningMessage("connecter vous SVP pour Modifier l'album");
			return $this->redirect()->toRoute('auth',array('action'=>'index'));
		}
		
		if (!$acl->isAllowed($role,__METHOD__)){  //si l'user co n'a pas le droit
				
			$this->flashMessenger()->addWarningMessage("desoler vous ne pouvez pas");
			return $this->redirect()->toRoute('album',array('action'=>'noprivilege'));
		}
		
		
		$id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('album', array(
                 'action' => 'add'
             ));
         }

        
         try {
             $album = $this->getAlbumTable()->getAlbum($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('album', array(
                 'action' => 'index'
             ));
         }

         $form  = new AlbumForm();
         $form->bind($album);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($album->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getAlbumTable()->saveAlbum($album);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('album');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
	}

	public function deleteAction()
	{
		
		$sm=$this->getServiceLocator();
		$auth=$sm->get("AuthenticationService");
		if ($auth->hasIdentity()){ //si il est co
			$identity= $auth->getIdentity();
			$role = $identity->role;
			$acl=$sm->get("AclManage");
		}else { //sinn redirect page auth
			$this->flashMessenger()->addWarningMessage("connecter vous SVP pour Supprimer l'album");
			return $this->redirect()->toRoute('auth',array('action'=>'index'));
		}
		
		if (!$acl->isAllowed($role,__METHOD__)){  //si l'user co n'a pas le droit
				
			$this->flashMessenger()->addWarningMessage("desoler vous ne pouvez pas");
			return $this->redirect()->toRoute('album',array('action'=>'noprivilege'));
		}
		
		
		$id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('album');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getAlbumTable()->deleteAlbum($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('album');
         }

         return array(
             'id'    => $id,
             'album' => $this->getAlbumTable()->getAlbum($id)
         );
	}
	

	public function affichemusicAction()
	{
		// récupérer l'id de la chanson
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id)
		{
			return $this->redirect()->toRoute('album', array(
					'action' => 'index'));
		}
		try
		{
			$sm = $this->getServiceLocator();
			$adapter = $sm->get("adapterService");
			$imagesTable = new TableGateway('images', $adapter);
			$imgsData = $imagesTable->select(array('id_chanson' => $id));
			$album = $this->getAlbumTable()->getAlbum($id);
		}
		catch (\Exception $ex)
		{
			$this->flashMessenger()->addInfoMessage("la chanson demander n'existe pas");
			return $this->redirect()->toRoute('album', array(
					'action' => 'index'));
		}
	
		return array(
				'id' => $id,
				'title' => $album->title,
				'artist' => $album->artist,
				'description' => $album->description,
				'images' => $imgsData,
		);
	}
	
	public function supmusicAction()
		
	{
		$sm = $this->getServiceLocator();
		$auth = $sm->get("AuthenticationService");
		if ($auth->hasIdentity()) // si un user est connecté
		{
			$identity = $auth->getIdentity();
			$role = $identity->role;
			$acl = $sm->get("AclManage");
		}
		else
		{  // si pas d'user redirect vers page d'authentification
			$this->flashMessenger()->addWarningMessage("connecter vous SVP pour suprimer la Zik");
			return $this->redirect()->toRoute('auth', array(
					'action' => 'index'));
		}
		if (!$acl->isAllowed($role, __METHOD__)) // si l'utilisateur connecté n'est pas le droit
		{
			$this->flashMessenger()->addWarningMessage("desoler vous ne pouvez pas");
			return $this->redirect()->toRoute('album', array(
					'action' => 'noprivilege'));
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id)
			return $this->redirect()->toRoute('album');
		$request = $this->getRequest();
		if ($request->isPost())
		{
			$del = $request->getPost('del', 'No');
			if ($del == 'Yes')
			{
				$id = (int) $request->getPost('id');
				$this->getAlbumTable()->deleteAlbum($id);
			}
			// Redirect to list of albums
			return $this->redirect()->toRoute('album');
		}
		return array(
				'id' => $id,
				'album' => $this->getAlbumTable()->getAlbum($id)
		);
	}
	
	
	public function modifiermusicAction()
	{
		$sm = $this->getServiceLocator();
		$auth = $sm->get("AuthenticationService");
		if ($auth->hasIdentity()) // si un user est connecté
		{
			$identity = $auth->getIdentity();
			$role = $identity->role;
			$acl = $sm->get("AclManage");
		}
		else
		{  // si pas d'user redirect vers page d'authentification
			$this->flashMessenger()->addWarningMessage("Merci de vous authentifier pour Modifier la Zik");
			return $this->redirect()->toRoute('auth', array(
					'action' => 'index'));
		}
		if (!$acl->isAllowed($role, __METHOD__)) // si l'utilisateur connecté n'est pas le droit
		{
			$this->flashMessenger()->addWarningMessage("desoler vous ne pouvez pas");
			return $this->redirect()->toRoute('album', array(
					'action' => 'noprivilege'));
		}
		$id = (int) $this->params()->fromRoute('id', 0);
		if (!$id)
		{
			return $this->redirect()->toRoute('album', array(
					'action' => 'index'
			));
		}
	
		try
		{
			$sm = $this->getServiceLocator();
			$adapter = $sm->get("adapterService");
			$imagesTable = new TableGateway('images', $adapter);
			$imgsData = $imagesTable->select(array('id_chanson' => $id));
			$album = $this->getAlbumTable()->getAlbum($id);
		}
		catch (\Exception $ex)
		{
			return $this->redirect()->toRoute('album', array(
					'action' => 'index'
			));
		}
		$form=new MusicForm();
		$form->bind($album);
		$form->get('submit')->setAttribute('value', 'Edit');
		$request = $this->getRequest();
		if ($request->isPost())
		{
			var_dump($_POST);exit;
			$form->setInputFilter($album->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid())
			{
				$this->getAlbumTable()->saveAlbum($album);
				// Redirect to list of albums
				return $this->redirect()->toRoute('album');
			}
		}
		return array(
				'id' => $id,
				'form' => $form,
				'images' => $imgsData,
		);
	}
	
	public function noprivilegeAction (){
		return array();
	}
	
	

	public function getAlbumTable()
	{
		if (!$this->albumTable)
		{
			$sm = $this->getServiceLocator();
			$this->albumTable = $sm->get('Album\Model\AlbumTable');
		}
		return $this->albumTable;
	}

}






