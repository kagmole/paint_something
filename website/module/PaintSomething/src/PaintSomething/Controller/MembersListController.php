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
 
    public function indexAction() {
        /*$parameter = $this->params()->fromRoute('parameter');
        $value = $this->params()->fromRoute('value');
        
        $startId = 0;
        
        // If we have a parameter AND a value for it
        if (isset($parameter) && isset($value)) {
            switch ($parameter) {
                case 'page':
                    $startId = ($value < 1) ? 0 : 20 * ($value - 1);
                    break;
                default:
                    // Unexpected parameter
                    break;
            }
        }
        $usersRangeData = $this->getUsersTable()->fetchRange($startId, 1);*/
    
        return new ViewModel(array(
            'users' => $this->getUsersTable()->fetchAll(),
        ));
    }
}