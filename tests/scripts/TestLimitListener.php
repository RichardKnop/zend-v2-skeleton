<?php

class TestLimitListener implements PHPUnit_Framework_TestListener
{
	/**
	 * Number of seconds that this test can run
	 * @var integer
	 */

	const TEST_LIMIT_TIME = 2;

	/**
	 * called when test is ended - determines if it was long and prints
	 * @param PHUnit_Framework_Test $test
	 * @param float $length the length of time for the test
	 */
	public function endTest(PHPUnit_Framework_Test $test, $length)
	{
		if ($length > self::TEST_LIMIT_TIME) {
			$this->_printError($test->getName() . " ran for {$length} seconds");
		}
	}

	/**
	 * Used to print error in error colors
	 * @param string $error
	 */
	protected function _printError($error)
	{
		print "\n\033[41m" . $error . "\033[0m\n";
	}

	/**
	 * Required for Interface
	 * (non-PHPdoc)
	 * @see PHPUnit_Framework_TestListener::startTest()
	 */
	public function startTest(PHPUnit_Framework_Test $test)
	{
		
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

