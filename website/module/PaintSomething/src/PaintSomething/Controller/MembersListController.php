<?php
namespace PaintSomething\Controller;

use Zend\Mvc\Controller\AbstractActionController;
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
    
    public function editAction() {
    
    }
    
    public function friendsAction() {
    
    }
    
    public function gamesAction() {
    
    }
 
    public function indexAction() {
        return new ViewModel(array(
            'users' => $this->getUsersTable()->fetchAll(),
        ));
    }
    
    public function profileAction() {
    
    }
}