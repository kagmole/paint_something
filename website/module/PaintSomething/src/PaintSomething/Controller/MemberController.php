<?php
namespace PaintSomething\Controller;

use PaintSomething\Form\AddFriendForm;
use PaintSomething\Form\EditMemberForm;
use PaintSomething\Model\Friends;
use PaintSomething\Model\Users;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

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
		/* If the user isn't connected redirect to home */
		$nm_authInfo = new Container('authentification_info');
		
		if(!isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home', array('action' => 'signin'));
		}
		
		/* If the user is trying to edit an other page than is own, redirect to the homepage */
		if ($this->params()->fromRoute('name') != $nm_authInfo->login) {
			return $this->redirect()->toRoute('home');
		}
		
		$userId = $this->getUsersTable()->getUserIdByLogin($this->params()->fromRoute('name'));
		$info = '';
	
		/* Prepare the "Edit member" form */
		$form = new EditMemberForm();
		$request = $this->getRequest();
		
		/* If we got a POST request */
		if ($request->isPost()) {
			$user = new Users();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			
			/* If the form is valid, according to the filter */
			if ($form->isValid()) {
				$data = array(
					'email' => $form->getData()['email'],
				);
				
				/* Did he tried to change his password? */
				if (!empty($form->getData()['new-password'])) {
					if ($form->getData()['new-password'] == $form->getData()['confirm-password']) {
						$data['password'] = sha1($form->getData()['new-password']);
					} else {
						$info = 'The two passwords were not the same.';
					}
				}
				/* Update data */
				$this->getUsersTable()->editUsersByIdWithData($userId, $data);
			}
		}
	
		return new ViewModel(array(
            'users' => $this->getUsersTable()->fetchUserByLogin($this->params()->fromRoute('name')),
			'form' => $form,
			'info' => $info,
        ));
    }
    
    public function friendsAction() {
		/* If the user isn't connected redirect to home */
		$nm_authInfo = new Container('authentification_info');
		
		if(!isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home', array('action' => 'signin'));
		}
		
		/* If the user is trying to view an other page than is own, redirect to the homepage */
		if ($this->params()->fromRoute('name') != $nm_authInfo->login) {
			return $this->redirect()->toRoute('home');
		}
		
		$userId = $this->getUsersTable()->getUserIdByLogin($this->params()->fromRoute('name'));
		$friendsId = $this->getFriendsTable()->getFriendsIdOfUserById($userId);
		$info = '';
	
		/* Prepare the "Add friend" form */
		$form = new AddFriendForm();
        $request = $this->getRequest();
		
		/* If we got a POST request */
        if ($request->isPost()) {
            $friend = new Friends();
            $form->setInputFilter($friend->getInputFilter());
            $form->setData($request->getPost());
			
			/* If the form is valid, according to the filter */
            if ($form->isValid()) {
				$friendId = $this->getUsersTable()->getUserIdByLogin($form->getData()['username']);
				
				/* Check if the login exists, if it is not the user himself, if he is not already his friend */
				if ($friendId == -1) {
					$info = 'User "' . $form->getData()['username'] . '" does not exist.';
				} else if ($friendId == $userId) {
					$info = 'You cannot be your friend.';
				} else if (in_array($friendId, $friendsId)) {
					$info = $form->getData()['username'] . ' is already your friend.';
				} else {
					$data = array(
						'id_user1' => $userId,
						'id_user2' => $friendId,
						'confirmed' => 0,
					);
					$friend->exchangeArray($data);
					$this->getFriendsTable()->saveFriends($friend);
				}
            }
        }
	
		return new ViewModel(array(
            'friends' => (count($friendsId) > 0) ? $this->getUsersTable()->fetchUsersById($friendsId) : array(),
			'form' => $form,
			'info' => $info,
			'login' => $this->params()->fromRoute('name'),
        ));
    }
    
    public function gamesAction() {
	
		/* If the user isn't connected redirect to home */
		$nm_authInfo = new Container('authentification_info');
		
		if(!isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home', array('action' => 'signin'));
		}
		
		/* If the user is trying to view an other page than is own, redirect to the homepage */
		if ($this->params()->fromRoute('name') != $nm_authInfo->login) {
			return $this->redirect()->toRoute('home');
		}
		
		/* Prepare datas for the view */
		$userId = $this->getUsersTable()->getUserIdByLogin($this->params()->fromRoute('name'));
		$gamesId = $this->getUsersGamesTable()->getGamesIdOfUserById($userId);
		
		return new ViewModel(array(
			'pending_games' => (count($gamesId) > 0) ? $this->getGamesTable()->fetchPendingGamesById($gamesId) : array(),
			'running_games' => (count($gamesId) > 0) ? $this->getGamesTable()->fetchRunningGamesById($gamesId) : array(),
			'finished_games' => (count($gamesId) > 0) ? $this->getGamesTable()->fetchFinishedGamesById($gamesId) : array(),
		));
    }
    
    public function indexAction() {	
		/* if the user isn't connected redirect to home */
		$nm_authInfo = new Container('authentification_info');
		
		if(!isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home', array('action' => 'signin'));
		}
		
		return new ViewModel(array(
            'users' => $this->getUsersTable()->fetchUserByLogin($this->params()->fromRoute('name')),
        ));
    }
}