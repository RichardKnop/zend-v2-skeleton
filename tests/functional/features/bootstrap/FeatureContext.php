<?php

use Behat\Behat\Context\ClosuredContextInterface,
	Behat\Behat\Context\TranslatedContextInterface,
	Behat\Behat\Context\BehatContext,
	Behat\Behat\Exception\PendingException,
	Behat\Behat\Event\SuiteEvent;
use Behat\Gherkin\Node\PyStringNode,
	Behat\Gherkin\Node\TableNode;

if (file_exists($boot = __DIR__ . '/../../../Bootstrap.php')) {
	require_once($boot);
}

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

class FeatureContext extends BehatContext
{

	/**
	 * Initializes context.
	 * Every scenario gets it's own context object.
	 *
	 * @param   array   $parameters     context parameters (set them up through behat.yml)
	 */
	public function __construct(array $parameters)
	{
		
	}

	/**
	 * @BeforeSuite
	 */
	public static function beforeSuite(SuiteEvent $event)
	{
//		self::_dropAndRecreateSchema();
		self::_killDevelopmentServer(self::SDP_STORE_PID_FILE);
		self::_startDevelopmentServer(self::SDP_STORE_URI, self::SDP_STORE_PID_FILE);
	}

	/**
	 * @AfterSuite
	 */
	public static function afterSuite(SuiteEvent $event)
	{
		self::_killDevelopmentServer(self::SDP_STORE_PID_FILE);
//		self::_dropAndRecreateSchema();
	}

	private static function _startDevelopmentServer($uri, $pidfile)
	{
		$publicDirectory = __DIR__ . '/../../../../public';
		$cmd = 'cd ' . $publicDirectory . ' && php -S ' . $uri . ' index.php';
		$outputfile = '/dev/null';
		shell_exec(sprintf("%s > %s 2>&1 & echo $! >> %s", $cmd, $outputfile, $pidfile));
		sleep(1);
	}

	private static function _killDevelopmentServer($pidfile)
	{
		if (file_exists($pidfile)) {
			$pids = file($pidfile);
			$runningProcesses = [];
			foreach (explode("\n", trim(shell_exec('ps aux | grep "php -S"'))) as $line) {
				$runningProcesses[] = explode(' ', preg_replace('!\s+!', ' ', $line))[1];
			}
			foreach ($pids as $pid) {
				if (in_array($pid, $runningProcesses)) {
					shell_exec('kill -15 ' . $pid);
				}
			}
			unlink($pidfile);
		}
	}

	private static function _dropAndRecreateSchema()
	{
		$database = Bootstrap::$em->getConnection()->getDatabase();
		Bootstrap::$em->getConnection()->query('DROP schema ' . $database);
		Bootstrap::$em->getConnection()->query('CREATE schema ' . $database);
		$documentRoot = __DIR__ . '/../../../../';
		shell_exec('cd ' . $documentRoot . ' && ant migrate');
	}

}