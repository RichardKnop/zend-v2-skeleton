<?php

class TestDbCleanupListener implements PHPUnit_Framework_TestListener
{

	/**
	 * called when test is started - starts transaction
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestListener::startTest()
	 */
	public function startTest(PHPUnit_Framework_Test $test)
	{
		Bootstrap::$em->beginTransaction();
	}

	/**
	 * called when test is ended - rolls back the transaction 
	 * @param PHUnit_Framework_Test $test
	 * @param float $length the length of time for the test
	 */
	public function endTest(PHPUnit_Framework_Test $test, $length)
	{
        Bootstrap::$em->rollback();
        Bootstrap::$em->clear();
	}

	/**
	 * Required for Interface
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestListener::addError()
	 */
	public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
	{
		
	}

	/**
	 * Required for Interface
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestListener::addFailure()
	 */
	public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
	{
		
	}

	/**
	 * Required for Interface
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestListener::addError()
	 */
	public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
	{
		
	}

	/**
	 * Required for Interface
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestListener::addSkippedTest()
	 */
	public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
	{
		
	}

	/**
	 * Required for Interface
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestListener::startTestSuite()
	 */
	public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
	{
		
	}

	/**
	 * Required for Interface
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestListener::endTestSuite()
	 */
	public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
	{
		
	}

}