<?php

namespace Admin\Form;

use Zend\Form\Form,
	Zend\InputFilter\Factory as InputFactory,
	Zend\InputFilter\InputFilter,
	Zend\InputFilter\InputFilterAwareInterface,
	Zend\InputFilter\InputFilterInterface;

class LoginForm extends Form implements InputFilterAwareInterface
{

	protected $_inputFilter;

	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('login');
		$this->setAttribute('method', 'post');
		$this->add(array(
			'name' => 'email',
			'attributes' => array(
				'type' => 'text',
			),
			'options' => array(
				'label' => 'Email',
			),
		));
		$this->add(array(
			'name' => 'password',
			'attributes' => array(
				'type' => 'password',
			),
			'options' => array(
				'label' => 'Password',
			),
		));
		$this->add(array(
			'name' => 'login',
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Login',
				'id' => 'loginbutton',
			),
		));
	}

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		$this->_inputFilter = $inputFilter;
	}

	public function getInputFilter()
	{
		if (!$this->_inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();

			$inputFilter->add($factory->createInput(array(
						'name' => 'email',
						'required' => true,
						'validators' => array(
							array('name' => 'EmailAddress'),
						),
					)));

			$inputFilter->add($factory->createInput(array(
						'name' => 'password',
						'required' => true,
					)));

			$this->_inputFilter = $inputFilter;
		}

		return $this->_inputFilter;
	}

}