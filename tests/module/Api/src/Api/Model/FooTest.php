<?php

use Api\Model\Foo;

class FooTest extends PHPUnit_Framework_TestCase
{

	protected $_object;

	public function setUp()
	{
		$this->_object = new Foo;
	}

	public function testBar()
	{
		$this->assertEquals('foo', $this->_object->bar());
	}

}