<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * A user.
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @property int $id
 * @property string $username
 * @property string $password
 */
class User implements InputFilterAwareInterface
{

	protected $inputFilter;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $username;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $password;

	public function __get($property)
	{
		return $this->$property;
	}

	public function __set($property, $value)
	{
		$this->$property = $value;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

	public function populate($data = array())
	{
		$this->id = $data['id'];
		$this->username = $data['username'];
		$this->password = $data['password'];
	}

	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$factory = new InputFactory();

			$inputFilter->add($factory->createInput(array(
					'name' => 'id',
					'required' => true,
					'filters' => array(
						array('name' => 'Int'),
					),
				)));

			$inputFilter->add($factory->createInput(array(
					'name' => 'username',
					'required' => true,
					'filters' => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name' => 'StringLength',
							'options' => array(
								'encoding' => 'UTF-8',
								'min' => 1,
								'max' => 100,
							),
						),
					),
				)));

			$inputFilter->add($factory->createInput(array(
					'name' => 'password',
					'required' => true,
					'filters' => array(
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name' => 'StringLength',
							'options' => array(
								'encoding' => 'UTF-8',
								'min' => 1,
								'max' => 50,
							),
						),
					),
				)));

			$this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}

}