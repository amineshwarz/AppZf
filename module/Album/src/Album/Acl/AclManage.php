<?php
namespace Album\Acl;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;


class AclManage extends Acl{
	
	private $resourceEdit ='Album\Controller\AlbumController::editAction';
	private $resourceAdd ='Album\Controller\AlbumController::addAction';
	private $resourceDelete ='Album\Controller\AlbumController::deleteAction';
	private $resourceSupMusic = 'Album\Controller\AlbumController::SupMusicAction';
	private $resourceModifierMusic = 'Album\Controller\AlbumController::ModifierMusicAction';
	
	
	public function __construct(){
		$this->addRole(new GenericRole('FANS'));
		$this->addRole(new GenericRole('ADMIN'));
		$this->addResource(new GenericResource($this->resourceEdit));
		$this->addResource(new GenericResource($this->resourceAdd));
		$this->addResource(new GenericResource($this->resourceDelete));
		$this->addResource(new GenericResource($this->resourceSupMusic));
		$this->addResource(new GenericResource($this->resourceModifierMusic));
		
		$this->allow('FANS', array(
			$this->resourceEdit,
			$this->resourceAdd,
			$this->resourceModifierMusic
		));
		
		$this->allow('ADMIN', array(
				$this->resourceEdit,
				$this->resourceAdd,
				$this->resourceDelete,
				$this->resourceModifierMusic,
				$this->resourceSupMusic
				
		));
		
	}
}
