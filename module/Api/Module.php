<?php

namespace Api;

use Zend\Mvc\MvcEvent;

class Module
{

	/**
	 * @param MvcEvent $e
	 */
	public function onBootstrap($e)
	{
		/** @var \Zend\ModuleManager\ModuleManager $moduleManager */
		$moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
		/** @var \Zend\EventManager\SharedEventManager $sharedEvents */
		$sharedEvents = $moduleManager->getEventManager()->getSharedManager();

		$sharedEvents->attach('Zend\Mvc\Controller\AbstractRestfulController', MvcEvent::EVENT_DISPATCH, array($this, 'postProcess'), -100);
		$sharedEvents->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'errorProcess'), 999);
	}

	/**
	 * @param MvcEvent $e
	 * @return null|\Zend\Http\PhpEnvironment\Response
	 */
	public function postProcess(MvcEvent $e)
	{
		$response = $e->getResponse();

		$headers = $response->getHeaders();
		$headers->addHeaderLine('Content-Type', 'application/json');
		$response->setHeaders($headers);

		if ($e->getResult() instanceof \Zend\View\Model\ViewModel) {
			if (is_array($e->getResult()->getVariables())) {
				$vars = $e->getResult()->getVariables();
			} else {
				$vars = null;
			}
		} else {
			$vars = $e->getResult();
		}

		$vars = array(
			'status' => array(
				'ok' => true,
			),
			'body' => $vars,
		);
		$content = \Zend\Json\Encoder::encode($vars);
		$response->setContent($content);
		return $response;
	}

	/**
	 * @param MvcEvent $e
	 * @return null|\Zend\Http\PhpEnvironment\Response
	 */
	public function errorProcess(MvcEvent $e)
	{
		$eventParams = $e->getParams();

		/** @var array $configuration */
		$configuration = $e->getApplication()->getConfig();

		$response = $e->getResponse();

		$vars = array();
		if (isset($eventParams['exception'])) {
			/** @var \Exception $exception */
			$exception = $eventParams['exception'];
			if ($exception->getCode()) {
				$response->setStatusCode($exception->getCode());
			}

			if ($configuration['errors']['show_exceptions']['message']) {
				$vars['errorMessage'] = $exception->getMessage();
			}
			if ($configuration['errors']['show_exceptions']['trace']) {
				$vars['errorTrace'] = $exception->getTrace();
			}
		}

		if (empty($vars)) {
			$vars['errorMessage'] = 'Something went wrong';
		}

		$headers = $response->getHeaders();
		$headers->addHeaderLine('Content-Type', 'application/json');
		$response->setHeaders($headers);

		$vars = array(
			'status' => array(
				'ok' => false,
			),
			'body' => array(
				'errorMessage' => $vars['errorMessage']
			),
		);
		$content = \Zend\Json\Encoder::encode($vars);
		$response->setContent($content);

		$e->stopPropagation();

		return $response;
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