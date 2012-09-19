<?php

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

class Bootstrap
{

    static public $config;
    static public $sm;
    static public $em;

    static public function go()
    {
        chdir(dirname(__DIR__));
        include __DIR__ . '/../init_autoloader.php';
        self::$config = include 'config/application.config.php';
        Zend\Mvc\Application::init(self::$config);
        self::$sm = self::getServiceManager(self::$config);
        self::$em = self::getEntityManager(self::$sm);
    }

    static public function getServiceManager($config)
    {
        $serviceManager = new ServiceManager(new ServiceManagerConfig);
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->get('ModuleManager')->loadModules();
        return $serviceManager;
    }

    static public function getEntityManager($serviceManager)
    {
        return $serviceManager->get('doctrine.entitymanager.orm_default');
    }

}

Bootstrap::go();