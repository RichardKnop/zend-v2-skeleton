<?php

use Api\Model\Foo,
	Zend\InputFilter\InputFilterInterface;

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