<?php

use Admin\Controller\IndexController,
	Zend\Http\Request,
	Zend\Http\Response,
	Zend\Mvc\MvcEvent,
	Zend\Mvc\Router\RouteMatch;

class IndexControllerTest extends PHPUnit_Framework_TestCase
{

	protected $_controller;
	protected $_request;
	protected $_response;
	protected $_routeMatch;
	protected $_event;

	public function setUp()
	{
		$this->_controller = new IndexController;
		$this->_request = new Request;
		$this->_response = new Response;
		$this->_event = new MvcEvent();
		$this->_routeMatch = new RouteMatch(array('controller' => 'index'));
		$this->_routeMatch->setMatchedRouteName('admin');
		$this->_event->setRouteMatch($this->_routeMatch);
		$this->_controller->setEvent($this->_event);
	}

	public function testIndexHttpStatusCode()
	{
		$this->_routeMatch->setParam('action', 'index');
		$this->_controller->dispatch($this->_request);
		$response = $this->_controller->getResponse();
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function testIndexReturnsViewModelInstance()
	{
		$this->_routeMatch->setParam('action', 'index');
		$viewModel = $this->_controller->dispatch($this->_request);
		$this->assertInstanceOf('Zend\View\Model\ViewModel', $viewModel);
	}

}