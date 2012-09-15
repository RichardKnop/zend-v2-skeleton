<?php

use Api\Controller\ResourceController,
	Zend\Http\Request,
	Zend\Http\Response,
	Zend\Mvc\MvcEvent,
	Zend\Mvc\Router\RouteMatch,
	Zend\Mvc\Exception\DomainException;

class ResourceControllerTest extends PHPUnit_Framework_TestCase
{

	protected $_controller;
	protected $_request;
	protected $_response;
	protected $_routeMatch;
	protected $_event;

	public function setUp()
	{
		$this->_controller = new ResourceController;
		$this->_request = new Request;
		$this->_response = new Response;
		$this->_routeMatch = new RouteMatch(array('controller' => 'resource'));
		$this->_event = new MvcEvent();
		$this->_event->setRouteMatch($this->_routeMatch);
		$this->_controller->setEvent($this->_event);
		$this->_controller->setServiceLocator(Bootstrap::getServiceManager());
	}

	public function testGetListHttpStatusCode()
	{
		$this->_controller->dispatch($this->_request, $this->_response);
		$this->assertEquals(200, $this->_response->getStatusCode());
	}

	public function testGetListResponseBody()
	{
		$expected = array(
			'a' => 'b',
			'c' => 'd',
			'e' => 'f',
		);
		$this->assertEquals(
			$expected,
			$this->_controller->dispatch($this->_request, $this->_response)
		);
	}
	
	public function testGetHttpStatusCode()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_controller->dispatch($this->_request, $this->_response);
		$this->assertEquals(200, $this->_response->getStatusCode());
	}
	
	public function testGetResponseBody()
	{
		$this->_routeMatch->setParam('id', 123);
		$response = $this->_controller->dispatch($this->_request, $this->_response);
		$expected = array(
			'id' => 123,
		);
		$this->assertEquals($expected, $response);
	}
	
	public function testCreateHttpStatusCode()
	{
		$this->_request->setMethod(Request::METHOD_POST);
		$this->_controller->dispatch($this->_request, $this->_response);
		$this->assertEquals(200, $this->_response->getStatusCode());
	}
	
	public function testCreateResponseBody()
	{
		$this->_request->setMethod(Request::METHOD_POST);
		$expected = array(
			'created'
		);
		$this->assertEquals(
			$expected,
			$this->_controller->dispatch($this->_request, $this->_response)
		);
	}
	
	/**
     * @expectedException DomainException
	 * @expectedExceptionMessage Missing identifier
     */
	public function testUpdateThrowsExceptionWhenNoID()
	{
		$this->_request->setMethod(Request::METHOD_PUT);
		$this->_controller->dispatch($this->_request, $this->_response);
	}
	
	public function testUpdateHttpStatusCode()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_PUT);
		$this->_controller->dispatch($this->_request, $this->_response);
		$this->assertEquals(200, $this->_response->getStatusCode());
	}
	
	public function testUpdateResponseBody()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_PUT);
		$expected = array(
			'updated'
		);
		$this->assertEquals(
			$expected,
			$this->_controller->dispatch($this->_request, $this->_response)
		);
	}
	
	/**
     * @expectedException DomainException
	 * @expectedExceptionMessage Missing identifier
     */
	public function testDeleteThrowsExceptionWhenNoID()
	{
		$this->_request->setMethod(Request::METHOD_DELETE);
		$this->_controller->dispatch($this->_request, $this->_response);
	}
	
	public function testDeleteHttpStatusCode()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_DELETE);
		$this->_controller->dispatch($this->_request, $this->_response);
		$this->assertEquals(200, $this->_response->getStatusCode());
	}
	
	public function testDeleteResponseBody()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_DELETE);
		$expected = array(
			'deleted'
		);
		$this->assertEquals(
			$expected,
			$this->_controller->dispatch($this->_request, $this->_response)
		);
	}

}