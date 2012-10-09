<?php

use Admin\Entity\AdminSession;

class AdminSessionTest extends PHPUnit_Framework_TestCase
{

	public function testCanCreateAdminSessionRowInDatabase()
	{
		$sessionId = $this->_insertAdminSession(uniqid(), 'abcd')->id;

		$adminSession = $this->_findAdminSessionById($sessionId);
		$this->assertInstanceOf('Admin\Entity\AdminSession', $adminSession);
	}

	private function _insertAdminSession($id, $data)
	{
		$now = new \DateTime(date('Y-m-d H:i:s', time()));
		$adminSession = new AdminSession;
		$adminSession->id = $id;
		$adminSession->data = $data;
		$adminSession->lastAccessed = $now;
		$adminSession->created = $now;
		Bootstrap::$em->persist($adminSession);
		Bootstrap::$em->flush();
		return $adminSession;
	}

	private function _findAdminSessionById($id)
	{
		return Bootstrap::$em->find('Admin\Entity\AdminSession', $id);
	}

}