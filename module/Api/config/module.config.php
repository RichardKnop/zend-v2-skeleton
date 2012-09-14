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
			'restful' => array(
				'type' => 'Zend\Mvc\Router\Http\Segment',
				'options' => array(
					'route' => '/api/:controller/[:id/]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id' => '[a-zA-Z0-9_-]*'
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'resource' => 'Api\Controller\ResourceController'
		),
	),
);