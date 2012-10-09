<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
	Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

	protected $_em;

	public function getEntityManager()
	{
		if (null === $this->_em) {
			$this->_em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->_em;
	}

	public function indexAction()
	{
		return new ViewModel();
	}

}
