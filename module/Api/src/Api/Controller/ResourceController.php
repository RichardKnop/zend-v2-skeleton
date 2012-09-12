<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Api\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

class ResourceController extends AbstractRestfulController
{

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