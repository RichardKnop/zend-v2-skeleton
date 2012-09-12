<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
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