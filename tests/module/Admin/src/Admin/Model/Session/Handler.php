<?php

namespace Admin\Model\Session;

use Admin\Entity\AdminSession;

class Handler implements \SessionHandlerInterface
{

	private $_em;

	public function __construct($entityManager)
	{
		$this->_em = $entityManager;
	}

	public function open($savePath, $sessionId)
	{
		return true;
	}

	public function close()
	{
		return true;
	}

	public function read($sessionId)
	{
		$adminSession = $this->_em->find('Admin\Entity\AdminSession', $sessionId);
		$now = new \DateTime(date('Y-m-d H:i:s', time()));
		if (null === $adminSession) {
			$adminSession = new AdminSession;
			$adminSession->id = $sessionId;
			$adminSession->created = $now;
			$adminSession->lastAccessed = $now;
			$this->_em->persist($adminSession);
			$this->_em->flush();
		} else {
			$adminSession->lastAccessed = $now;
			$this->_em->persist($adminSession);
			$this->_em->flush();
			return $adminSession->data;
		}
		return '';
	}

	public function write($sessionId, $sessionData)
	{
		if (empty($sessionId) || empty($sessionData)) {
			return false;
		}
		$adminSession = $this->_em->find('Admin\Entity\AdminSession', $sessionId);
		if (null === $adminSession) {
			return false;
		}
		$adminSession->data = $sessionData;
		$adminSession->lastAccessed = new \DateTime(date('Y-m-d H:i:s', time()));
		$this->_em->persist($adminSession);
		$this->_em->flush();
		return true;
	}

	public function destroy($sessionId)
	{
		$adminSession = $this->_em->find('Admin\Entity\AdminSession', $sessionId);
		if (null === $adminSession) {
			return false;
		}
		$this->_em->remove($adminSession);
		$this->_em->flush();
		return true;
	}

	public function gc($maxlifetime = 600)
	{
		foreach ($this->_em->getRepository('Admin\Entity\AdminSession')->findAll() as $adminSession) {
			if ($adminSession->lastAccessed->getTimestamp() + $maxlifetime < time()) {
				$this->_em->remove($adminSession);
				$this->_em->flush();
			}
		}
		return true;
	}

}