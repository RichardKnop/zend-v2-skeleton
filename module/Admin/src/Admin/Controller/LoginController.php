<?php

namespace Admin\Controller;

use Admin\Model\AbstractController,
	Zend\View\Model\ViewModel,
	Admin\Form\LoginForm,
	Admin\Entity\AdminUser,
	Admin\Model\Session\Wrapper as SessionWrapper;

class LoginController extends AbstractController
{

	public function indexAction()
	{
		$form = new LoginForm();

		$error = null;

		$request = $this->getRequest();
		if ($request->isPost()) {
			$form->setInputFilter($form->getInputFilter());
			$form->setData($request->getPost());

			if ($form->isValid()) {
				$adminUser = new AdminUser;
				$adminUser->email = $form->getData()['email'];
				$adminUser->password = $form->getData()['password'];

				if (!$adminUser->authenticate($this->getEntityManager())) {
					$error = 'Invalid credentials';
				} else {
					SessionWrapper::setValue('loggedIn', $adminUser->email);
					return $this->redirect()->toRoute('admin', array('controller' => 'index', 'action' => 'index'));
				}
			}
		}

		return new ViewModel(array(
					'error' => $error,
					'form' => $form));
	}

	public function logoutAction()
	{
		if (null !== SessionWrapper::getValue('loggedIn')) {
			SessionWrapper::destroy();
		}
		return $this->redirect()->toRoute('admin', array('controller' => 'login', 'action' => 'index'));
	}

}