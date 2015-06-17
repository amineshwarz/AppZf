<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'Crm\Controller\Crm' => 'Crm\Controller\CrmController',
						'Crm\Controller\Auth' => 'Crm\Controller\AuthController',
				),
		),
		
		'router' => array(
				'routes' => array(
						'crm' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/crm[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Crm\Controller\Crm',
												'action'     => 'index',
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
												'controller' => 'Crm\Controller\Auth',
												'action' => 'index',
										),
								),
						),
						'afficheclient' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '/afficheclient[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id'     => '[0-9]+',
										),
										'defaults' => array(
												'controller' => 'Crm\Controller\Crm',
												'action'     => 'afficheclient',
										),
								),
						),
						
				),
		),
		
		'view_manager' => array(
				'template_path_stack' => array(
						'crm' => __DIR__ . '/../view',
				),
		),
);