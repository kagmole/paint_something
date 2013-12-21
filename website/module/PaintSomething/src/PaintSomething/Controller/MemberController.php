<?php
namespace PaintSomething\Controller;

use PaintSomething\Form\AddFriendForm;
use PaintSomething\Form\EditMemberForm;
use PaintSomething\Model\Friends;
use PaintSomething\Model\Users;
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
		$userId = $this->getUsersTable()->getUserIdByLogin($this->params()->fromRoute('name'));
		$info = '';
	
		$form = new EditMemberForm();
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$user = new Users();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				// TODO Check email validity
				$data = array(
					'email' => $form->getData()['email'],
				);
				
				if (!empty($form->getData()['new-password'])) {
					if ($form->getData()['new-password'] == $form->getData()['confirm-password']) {
						$data['password'] = sha1($form->getData()['new-password']);
					} else {
						$info = 'The two passwords were not the same.';
					}
				}
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
		$userId = $this->getUsersTable()->getUserIdByLogin($this->params()->fromRoute('name'));
		$friendsId = $this->getFriendsTable()->getFriendsIdOfUserById($userId);
		$info = '';
	
		$form = new AddFriendForm();
        $request = $this->getRequest();
		
        if ($request->isPost()) {
            $friend = new Friends();
            $form->setInputFilter($friend->getInputFilter());
            $form->setData($request->getPost());
			
            if ($form->isValid()) {
				$friendId = $this->getUsersTable()->getUserIdByLogin($form->getData()['username']);
				
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