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

	/**
	 * Return list of resources
	 *
	 * @return array
	 */
	public function getList()
	{
		return array(
			'a' => 'b',
			'c' => 'd',
			'e' => 'f',
		);
	}

	/**
	 * Return single resource
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function get($id)
	{
		return array(
			'id' => $id,
		);
	}

	/**
	 * Create a new resource
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function create($data)
	{
		return array(
			'created',
		);
	}

	/**
	 * Update an existing resource
	 *
	 * @param mixed $id
	 * @param mixed $data
	 * @return mixed
	 */
	public function update($id, $data)
	{
		return array(
			'updated',
		);
	}

	/**
	 * Delete an existing resource
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function delete($id)
	{
		return array(
			'deleted',
		);
	}

}