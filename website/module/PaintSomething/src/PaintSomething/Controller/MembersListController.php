<?php
namespace PaintSomething\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class MembersListController extends AbstractActionController {

    protected $usersTable;
    
    public function getUsersTable() {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('PaintSomething\Model\UsersTable');
        }
        return $this->usersTable;
    }
 
    public function indexAction() { 
		/* If the user isn't connected redirect to home */
		$nm_authInfo = new Container('authentification_info');
		
		if(!isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home', array('action' => 'signin'));
		}
		
		return new ViewModel(array(
			'users' => $this->getUsersTable()->fetchAll(),
		));
    }
}