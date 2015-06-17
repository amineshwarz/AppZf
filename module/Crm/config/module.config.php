<?php
return array(
		'controllers' => array(
				'invokables' => array(
						'Crm\Controller\Crm' => 'Crm\Controller\CrmController',
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
				),
		),
		
		'view_manager' => array(
				'template_path_stack' => array(
						'crm' => __DIR__ . '/../view',
				),
		),
);