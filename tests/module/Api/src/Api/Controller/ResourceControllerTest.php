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
		$this->_routeMatch = new RouteMatch(array('controller' => 'resource'));
		$this->_event = new MvcEvent();
		$this->_event->setRouteMatch($this->_routeMatch);
		$this->_controller->setEvent($this->_event);
	}

	public function testGetListHttpStatusCode()
	{
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals(200, $response->getStatusCode());
	}
	
	public function testGetListContentTypeHeader()
	{
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals('application/json', $response->getHeaders()->get('Content-Type')->getFieldValue());
	}

	public function testGetListResponseBody()
	{
		$response = $this->_controller->dispatch($this->_request);
		$expected = array(
			'a' => 'b',
			'c' => 'd',
			'e' => 'f',
		);
		$this->assertEquals(json_encode($expected), $response->getBody());
	}
	
	public function testGetHttpStatusCode()
	{
		$this->_routeMatch->setParam('id', 123);
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals(200, $response->getStatusCode());
	}
	
	public function testGetContentTypeHeader()
	{
		$this->_routeMatch->setParam('id', 123);
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals('application/json', $response->getHeaders()->get('Content-Type')->getFieldValue());
	}
	
	public function testGetResponseBody()
	{
		$this->_routeMatch->setParam('id', 123);
		$response = $this->_controller->dispatch($this->_request);
		$expected = array(
			'id' => 123,
		);
		$this->assertEquals(json_encode($expected), $response->getBody());
	}
	
	public function testCreateHttpStatusCode()
	{
		$this->_request->setMethod(Request::METHOD_POST);
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals(200, $response->getStatusCode());
	}
	
	public function testCreateContentTypeHeader()
	{
		$this->_request->setMethod(Request::METHOD_POST);
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals('application/json', $response->getHeaders()->get('Content-Type')->getFieldValue());
	}
	
	public function testCreateResponseBody()
	{
		$this->_request->setMethod(Request::METHOD_POST);
		$response = $this->_controller->dispatch($this->_request);
		$expected = array(
			'created'
		);
		$this->assertEquals(json_encode($expected), $response->getBody());
	}
	
	/**
     * @expectedException DomainException
	 * @expectedExceptionMessage Missing identifier
     */
	public function testUpdateThrowsExceptionWhenNoID()
	{
		$this->_request->setMethod(Request::METHOD_PUT);
		$this->_controller->dispatch($this->_request);
	}
	
	public function testUpdateHttpStatusCode()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_PUT);
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals(200, $response->getStatusCode());
	}
	
	public function testUpdateContentTypeHeader()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_PUT);
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals('application/json', $response->getHeaders()->get('Content-Type')->getFieldValue());
	}
	
	public function testUpdateResponseBody()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_PUT);
		$response = $this->_controller->dispatch($this->_request);
		$expected = array(
			'updated'
		);
		$this->assertEquals(json_encode($expected), $response->getBody());
	}
	
	/**
     * @expectedException DomainException
	 * @expectedExceptionMessage Missing identifier
     */
	public function testDeleteThrowsExceptionWhenNoID()
	{
		$this->_request->setMethod(Request::METHOD_DELETE);
		$this->_controller->dispatch($this->_request);
	}
	
	public function testDeleteHttpStatusCode()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_DELETE);
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals(200, $response->getStatusCode());
	}
	
	public function testDeleteContentTypeHeader()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_DELETE);
		$response = $this->_controller->dispatch($this->_request);
		$this->assertEquals('application/json', $response->getHeaders()->get('Content-Type')->getFieldValue());
	}
	
	public function testDeleteResponseBody()
	{
		$this->_routeMatch->setParam('id', 123);
		$this->_request->setMethod(Request::METHOD_DELETE);
		$response = $this->_controller->dispatch($this->_request);
		$expected = array(
			'deleted'
		);
		$this->assertEquals(json_encode($expected), $response->getBody());
	}

}