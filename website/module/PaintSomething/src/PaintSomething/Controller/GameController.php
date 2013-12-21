<?php
namespace PaintSomething\Controller;

use PaintSomething\Form\NewGameForm;
use PaintSomething\Form\NewGameFormFilter;
use PaintSomething\Model\Friends;
use PaintSomething\Model\FriendsTable;
use PaintSomething\Model\Users;
use PaintSomething\Model\UsersTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class GameController extends AbstractActionController {

    protected $friendsTable;
    protected $usersTable;
	
	public function getFriendsTable() {
        if (!$this->friendsTable) {
            $sm = $this->getServiceLocator();
            $this->friendsTable = $sm->get('PaintSomething\Model\FriendsTable');
        }
        return $this->friendsTable;
    }
    
    public function getUsersTable() {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('PaintSomething\Model\UsersTable');
        }
        return $this->usersTable;
    }

    public function indexAction() {
		return $this->redirect()->toRoute('game', array('action' => 'new'));
    }
    
    public function newAction() {
		$nm_authInfo = new Container('authentification_info');
	
		$userId = $this->getUsersTable()->getUserIdByLogin($nm_authInfo->login);
		$friendsId = $this->getFriendsTable()->getFriendsIdOfUserById($userId);
		$info = '';
		
		$form = new NewGameForm();
		$request = $this->getRequest();
		
		if (count($friendsId) > 1) {					
			if ($request->isPost()) {
				$count = 0;
			
				foreach ($request->getPost() as $key => $value) {
					if (!empty($value)) {
						$count++;
					}
				}
			
				$filter = new NewGameFormFilter();
				$filter->generateCheckboxesInputFilterByCount(count($friendsId));
				$form->setInputFilter($filter->getInputFilter());
				$form->setData($request->getPost());
				
				if ($form->isValid()) {
					$players = array();
				
					foreach ($form->getData() as $key => $value) {
						if(!empty($value)) {
							array_push($players, $value);
						}
					}
					array_pop($players);
					
					if (count($players) > 1) {
						// create a game
						//return $this->redirect()->toRoute('game', array('action' => 'play', 'id' => ''));
					} else {
						$info = 'You must invite at least 2 friends';
					}				
				}
			}
		} else {
			$info = 'You must have at least 2 friends to invite to create a game';
		}
	
		return new ViewModel(array(
			'friends' => (count($friendsId) > 0) ? $this->getUsersTable()->fetchUsersById($friendsId) : array(),
			'form' => $form,
			'info' => $info,
        ));
    }
    
    public function playAction() {
		return new ViewModel(array(
			'gameId'=>$this->params()->fromRoute('id'),
		));
    }

}