<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM,
	DoctrineModule\Authentication\Adapter\ObjectRepository as DoctrineAdapter,
	Zend\Authentication\AuthenticationService;

/**
 * An admin user.
 *
 * @ORM\Entity
 * @ORM\Table(name="adminUser",indexes={@ORM\Index(name="admin_user_search_idx", columns={"email", "password"})})
 */
class AdminUser
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $email;

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

	public function authenticate($entityManager)
	{
		$adapter = new DoctrineAdapter;
		$adapter->setOptions(array(
			'objectManager' => $entityManager,
			'identityClass' => 'Admin\Entity\AdminUser',
			'identityProperty' => 'email',
			'credentialProperty' => 'password',
			'credentialCallable' => 'Admin\Entity\AdminUser::hashPassword'));
		$adapter->setIdentityValue($this->email);
		$adapter->setCredentialValue($this->password);

		$authService = new AuthenticationService;
		$result = $authService->authenticate($adapter);
		return $result->isValid();
	}

	public static function hashPassword($identity, $plaintext)
	{
		return md5($plaintext);
	}

}