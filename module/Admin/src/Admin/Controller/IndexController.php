<?php

namespace Admin\Controller;

use Admin\Model\AbstractController,
	Zend\View\Model\ViewModel;

class IndexController extends AbstractController
{

	public function indexAction()
	{
		return new ViewModel();
	}

}