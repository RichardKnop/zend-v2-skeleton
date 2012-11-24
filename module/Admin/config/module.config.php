<?php

namespace Admin;

return array(
	'router' => array(
		'routes' => array(
			'admin' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/admin/[:controller/[:action/]]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					),
					'defaults' => array(
						'controller' => 'login',
						'action' => 'index',
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Admin\Controller\Index' => 'Admin\Controller\IndexController',
			'Admin\Controller\Login' => 'Admin\Controller\LoginController',
		),
		'aliases' => array(
			'index' => 'Admin\Controller\Index',
			'login' => 'Admin\Controller\Login',
		),
	),
	'view_manager' => array(
		'display_not_found_reason' => true,
		'display_exceptions' => true,
		'doctype' => 'HTML5',
		'not_found_template' => 'error/404',
		'exception_template' => 'error/index',
		'template_map' => array(
			'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
			'layout/login' => __DIR__ . '/../view/layout/login.phtml',
			'admin/login/index' => __DIR__ . '/../view/admin/login/index.phtml',
			'admin/index/index' => __DIR__ . '/../view/admin/index/index.phtml',
			'error/404' => __DIR__ . '/../view/error/404.phtml',
			'error/index' => __DIR__ . '/../view/error/index.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	'navigation' => array(
		'default' => array(
			array(
				'label' => 'Home',
				'controller' => 'index',
				'action' => 'index',
			),
			array(
				'label' => 'Log out',
				'controller' => 'login',
				'action' => 'logout',
			),
		)
	),
	'doctrine' => array(
		'driver' => array(
			__NAMESPACE__ . '_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
				),
			),
		),
	),
);