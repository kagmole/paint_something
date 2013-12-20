<?php
namespace PaintSomething\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MemberController extends AbstractActionController {

    protected $friendsTable;
	protected $gamesTable;
    protected $usersTable;
	protected $usersGamesTable;
    
    public function getFriendsTable() {
        if (!$this->friendsTable) {
            $sm = $this->getServiceLocator();
            $this->friendsTable = $sm->get('PaintSomething\Model\FriendsTable');
        }
        return $this->friendsTable;
    }
	
	public function getGamesTable() {
        if (!$this->gamesTable) {
            $sm = $this->getServiceLocator();
            $this->gamesTable = $sm->get('PaintSomething\Model\GamesTable');
        }
        return $this->gamesTable;
	}
    
    public function getUsersTable() {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('PaintSomething\Model\UsersTable');
        }
        return $this->usersTable;
    }
	
	public function getUsersGamesTable() {
		if (!$this->usersGamesTable) {
			$sm = $this->getServiceLocator();
			$this->usersGamesTable = $sm->get('PaintSomething\Model\UsersGamesTable');
		}
		return $this->usersGamesTable;
	}
    
    public function editAction() {
		return new ViewModel(array(
            'users' => $this->getUsersTable()->fetchUserByLogin($this->params()->fromRoute('name')),
        ));
    }
    
    public function friendsAction() {
		$userId = $this->getUsersTable()->getUserIdByLogin($this->params()->fromRoute('name'));
		$friendsId = $this->getFriendsTable()->getFriendsIdOfUserById($userId);
	
		return new ViewModel(array(
            'friends' => $this->getUsersTable()->fetchUsersById($friendsId),
        ));
    }
    
    public function gamesAction() {
		$userId = $this->getUsersTable()->getUserIdByLogin($this->params()->fromRoute('name'));
		$gamesId = $this->getUsersGamesTable()->getGamesIdOfUserById($userId);
		
		return new ViewModel(array(
			'pending_games' => $this->getGamesTable()->fetchPendingGamesById($gamesId),
			'running_games' => $this->getGamesTable()->fetchRunningGamesById($gamesId),
			'finished_games' => $this->getGamesTable()->fetchFinishedGamesById($gamesId),
		));
    }
    
    public function indexAction() {	
		return new ViewModel(array(
            'users' => $this->getUsersTable()->fetchUserByLogin($this->params()->fromRoute('name')),
        ));
    }
}