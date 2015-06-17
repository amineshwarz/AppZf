<?php

namespace Album;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

  // Add these import statements:
 use Album\Acl\AclManage;
 use Album\Model\Album;
 use Album\Model\AlbumTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
 
 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
	 
	 public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Album\Model\AlbumTable' =>  function($sm) {
                     $tableGateway = $sm->get('AlbumTableGateway');
                     $table = new AlbumTable($tableGateway);
                     return $table;
                 },
                 'AlbumTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Album());
                     return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                 },
								'AuthenticationService' => function ($sm) {
                    $auth = new AuthenticationService;
                    $auth->setStorage(new Session());
                    return $auth;
                },
                'AclManage'=> function($sm){
                	$acl= new AclManage();
                	return $acl;
                },
                'imagesTableGateway' => function ($sm) {
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	$resultSetPrototype = new ResultSet();
                	$resultSetPrototype->setArrayObjectPrototype(new Song());
                	return new TableGateway('images', $dbAdapter, null, $resultSetPrototype);
                },
                'adapterService' => function($sm){
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                	return $dbAdapter;
                },
             ),
         );
     }
	 
	 public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'identity' => function($sm) {
                    $identity = new \Zend\View\Helper\Identity();
                    $identity->setAuthenticationService($sm->getServiceLocator()->get('AuthenticationService'));
                    return $identity;
                }
            )
        );
    }
 }