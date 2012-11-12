<?php

namespace Admin\Model;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\Mvc\MvcEvent,
	Admin\Model\Session\Wrapper as SessionWrapper;

class AbstractController extends AbstractActionController
{

	protected $_em;

	public function getEntityManager()
	{
		if (null === $this->_em) {
			$this->_em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->_em;
	}

	public function onDispatch(MvcEvent $e)
	{
		//SessionWrapper::init();
		parent::onDispatch($e);
	}

}