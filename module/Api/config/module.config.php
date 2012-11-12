<?php

namespace Api;

return array(
	'errors' => array(
		'show_exceptions' => array(
			'message' => true,
			'trace' => true
		)
	),
	'router' => array(
		'routes' => array(
			'default' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/api/v1/:controller/[:id/]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[:a-zA-Z0-9_-]*',
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Api\Controller\Resource' => 'Api\Controller\ResourceController',
		),
		'aliases' => array(
			'resource' => 'Api\Controller\Resource',
		),
	),
	'doctrine' => array(
		'driver' => array(
			__NAMESPACE__ . '_driver' => array(
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
			),
			'orm_default' => array(
				'drivers' => array(
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
				),
			),
		),
	),
);