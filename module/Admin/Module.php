<?php

namespace Admin;

use Admin\Controller\LoginController,
	Admin\Model\Session\Wrapper as SessionWrapper,
	Zend\Mvc\MvcEvent;

class Module
{

	public function onBootstrap($e)
	{
		$moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
		$sharedEvents = $moduleManager->getEventManager()->getSharedManager();
		$sharedEvents->attach(__NAMESPACE__, MvcEvent::EVENT_DISPATCH, array($this, 'authenticate'), -100);
	}

	public function authenticate(MvcEvent $e)
	{
		$controller = $e->getTarget();
		$entityManager = $e->getApplication()->getServiceManager()->get('doctrine.entitymanager.orm_default');
		SessionWrapper::init($entityManager);

		if ($controller instanceof LoginController) {
			$controller->layout('layout/login');
		} else {
			$controller->layout('layout/admin');
		}
		$loggedIn = SessionWrapper::getValue('loggedIn');
		if (null === $loggedIn && !($controller instanceof LoginController)) {
			$controller->redirect()->toRoute('admin', array('controller' => 'login', 'action' => 'index'));
		}
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
		);
	}

}