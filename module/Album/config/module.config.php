<?php
return array(
     'controllers' => array(
         'invokables' => array(
             'Album\Controller\Album' => 'Album\Controller\AlbumController',
						 'Album\Controller\Auth' => 'Album\Controller\AuthController',
         ),
     ),
	
		'router' => array(
         'routes' => array(
             'album' => array(
								'type' => 'segment',
								'options' => array(
									'route' => '/album[/][:action][/:id]',
									'constraints' => array(
										'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
										'id' => '[0-9]+',
									),
									'defaults' => array(
										'controller' => 'Album\Controller\Album',
										'action' => 'index',
									),
								),
							),
							'auth' => array(
								'type' => 'segment',
								'options' => array(
									'route' => '/auth[/][:action]',
									'constraints' => array(
										'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
									),
									'defaults' => array(
										'controller' => 'Album\Controller\Auth',
										'action' => 'index',
									),
								),
							),
					),
     ),
	
     'view_manager' => array(
         'template_path_stack' => array(
             'album' => __DIR__ . '/../view',
         ),
     ),
 );
return array(
		// Service manager
		'service_manager' => array(
				'factories' => array(
						'Common\Acl\Acl' => function($serviceManager) {
							$authenticationService = $serviceManager->get('Zend\Authentication\AuthenticationService');
							$acl = new Acl($serviceManager, $authenticationService);

							return $acl;
						})));

