<?php

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

class Bootstrap
{
	static $serviceManager;
	
	static public function go()
	{
		chdir(dirname(__DIR__));
		include __DIR__ . '/../init_autoloader.php';
		$config = include 'config/application.config.php';
		Zend\Mvc\Application::init($config);
		
		$serviceManager = new ServiceManager(new ServiceManagerConfig);
		$serviceManager->setService('ApplicationConfig', $config);
		$serviceManager->get('ModuleManager')->loadModules();

		self::$serviceManager = $serviceManager;
	}
	
	static public function getServiceManager()
	{
		return self::$serviceManager;
	}
}

Bootstrap::go();