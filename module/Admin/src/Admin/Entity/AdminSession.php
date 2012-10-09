<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * An admin session.
 *
 * @ORM\Entity
 * @ORM\Table(name="adminSession",indexes={@ORM\Index(name="admin_session_search_idx", columns={"lastAccessed", "created"})})
 */
class AdminSession
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="string", length=32);
	 */
	protected $id;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $data;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $lastAccessed;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $created;

	public function __get($property)
	{
		return $this->$property;
	}

	public function __set($property, $value)
	{
		$this->$property = $value;
	}

}