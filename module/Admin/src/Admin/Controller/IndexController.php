<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,
    Doctrine\ORM\EntityManager,
    Admin\Entity\User;

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
//        $user = new User();
//        $user->populate(array(
//            'username' => 'foo_' . time(),
//            'password' => md5('foo')
//        ));
//        $this->getEntityManager()->persist($user);
//        $this->getEntityManager()->flush();

        return new ViewModel();
    }

}
