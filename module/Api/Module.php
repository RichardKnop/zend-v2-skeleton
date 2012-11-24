<?php

namespace Api;

use Zend\Mvc\MvcEvent;

class Module
{

	public function onBootstrap($e)
	{
		$moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
		$sharedEvents = $moduleManager->getEventManager()->getSharedManager();
		$sharedEvents->attach('Zend\Mvc\Controller\AbstractRestfulController', MvcEvent::EVENT_DISPATCH, array($this, 'postProcess'), -100);
		$sharedEvents->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'errorProcess'), 999);
	}

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

	public function errorProcess(MvcEvent $e)
	{
		$response = $e->getResponse();
		$status = $this->_getErrorStatus($e);

		$headers = $response->getHeaders();
		$headers->addHeaderLine('Content-Type', 'application/json');
		$response->setHeaders($headers);

		$vars = ['status' => $status, 'body' => ''];
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

	private function _getErrorStatus(MvcEvent $e)
	{
		$eventParams = $e->getParams();
		$response = $e->getResponse();
		$status = ['ok' => false];
		$translator = $this->_getTranslator($e);
		if (isset($eventParams['exception'])) {
			$exception = $eventParams['exception'];
			if (!($exception instanceof \Api\Model\Exception)) {
				$exception = new \Api\Model\Exception($exception->getMessage(), 500);
			}
			if ($exception->getCode()) {
//				$response->setStatusCode($exception->getCode());
				$response->setStatusCode(200);
				$status['code'] = $exception->getCode();
			}
			$errorMessage = $exception->getMessage();
			$status['usrMsg'] = $translator->translate($errorMessage);
			$status['debugMsg'] = strlen($exception->getDebugMessage()) > 0 ? $exception->getDebugMessage() : null; //Doing this so we don't return empty strings, don't return the property at all
			$status['redirectURL'] = strlen($exception->getRedirectURL()) > 0 ? $exception->getRedirectURL() : null;
			$status['redirectURLLaunchBrowser'] = $exception->getRedirectURLLaunchBrowser();
			$status['internalCode'] = $exception->getInternalErrorCode();
		} else {
			$status['usrMsg'] = $translator->translate('An application error has occurred');
		}
		return $status;
	}

	private function _getTranslator(MvcEvent $e)
	{
		$translator = $e->getApplication()->getServiceManager()->get('translate');
		$translator->addTranslationFilePattern('phparray', __DIR__ . '/language/', '%s.php');
		$acceptLanguage = $e->getRequest()->getHeader('AcceptLanguage');
		if ($acceptLanguage) {
			$translator->setLocale(\Locale::acceptFromHttp($acceptLanguage->getFieldValue()));
		}
		return $translator;
	}

}