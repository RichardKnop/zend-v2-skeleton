<?php

namespace Api\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

class ResourceController extends AbstractRestfulController
{

	private $_em;

	public function getEntityManager()
	{
		if (null === $this->_em) {
			$this->_em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->_em;
	}

	public function setEntityManager($entityManager)
	{
		$this->_em = $entityManager;
	}

	public function getList()
	{
		return array(
			'foo',
			'bar',
		);
	}

	public function get($id)
	{
		return array(
			'id' => $id,
		);
	}

	public function create($data)
	{
		$this->getResponse()->setStatusCode(201);
		return array(
			'created',
		);
	}

	public function update($id, $data)
	{
		return array(
			'updated',
		);
	}

	public function delete($id)
	{
		return array(
			'deleted',
		);
	}

}