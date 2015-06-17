<?php
namespace Crm;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

use Crm\Model\client;
use Crm\Model\ClientTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


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
						'Crm\Model\ClientTable' =>  function($sm) {
							$tableGateway = $sm->get('ClientTableGateway');
							$table = new ClientTable($tableGateway);
							return $table;
						},
						'ClientTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Client());
							return new TableGateway('client', $dbAdapter, null, $resultSetPrototype);
						},
				),
		);
	}
}