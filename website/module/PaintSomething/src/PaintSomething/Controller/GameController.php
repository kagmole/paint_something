<?php
namespace PaintSomething\Controller;

use PaintSomething\Form\AcceptInvitationForm;
use PaintSomething\Form\AcceptInvitationFormFilter;
use PaintSomething\Form\NewGameForm;
use PaintSomething\Form\NewGameFormFilter;
use PaintSomething\Form\SuggestWordForm;
use PaintSomething\Form\SuggestWordFormFilter;
use PaintSomething\Model\Dictionary;
use PaintSomething\Model\Friends;
use PaintSomething\Model\Games;
use PaintSomething\Model\Users;
use PaintSomething\Model\UsersGames;
use Zend\Math\Rand;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class GameController extends AbstractActionController {

	protected $dictionaryTable;
    protected $friendsTable;
	protected $gamesTable;
    protected $usersTable;
	protected $usersGamesTable;
	
	public function getDictionaryTable() {
        if (!$this->dictionaryTable) {
            $sm = $this->getServiceLocator();
            $this->dictionaryTable = $sm->get('PaintSomething\Model\DictionaryTable');
        }
        return $this->dictionaryTable;
    }
	
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

    public function indexAction() {
		return $this->redirect()->toRoute('game', array('action' => 'new'));
    }
    
    public function newAction() {		
		/* if the user isn't connected redirect to home */
		$nm_authInfo = new Container('authentification_info');
		
		if(!isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home', array('action' => 'signin'));
		}
	
		$userId = $this->getUsersTable()->getUserIdByLogin($nm_authInfo->login);
		$friendsId = $this->getFriendsTable()->getFriendsIdOfUserById($userId);
		$info = '';
		
		/* Prepare the "New game" form */
		$form = new NewGameForm();
		$request = $this->getRequest();
		
		/* Check if the user has enough friends to start a party */
		if (count($friendsId) > 0) {
			/* If we got a POST request */
			if ($request->isPost()) {
				$count = 0;
			
				/* How much checkboxes did the user check? */
				foreach ($request->getPost() as $key => $value) {
					if (!empty($value)) {
						$count++;
					}
				}
				
				$filter = new NewGameFormFilter();
				
				/* Generate a filter, depending on his number of friends (e.g. : 6 friends = 6 checkboxes to check) */
				$filter->generateCheckboxesInputFilterByCount(count($friendsId));
				$form->setInputFilter($filter->getInputFilter());
				$form->setData($request->getPost());
				
				/* If the form is valid, according to the filter */
				if ($form->isValid()) {
					$players = array();
				
					/* The value of the checkboxes contains the friends name */
					foreach ($form->getData() as $key => $value) {
						if(!empty($value)) {
							array_push($players, $value);
						}
					}
					/* The last value is the value of the submit button : just pop it away */
					array_pop($players);
					
					/* If he has at least choose 1 friend */
					if (count($players) > 0) {
						/* Start a new game : choose a word to draw */
						$dictionarySet = $this->getDictionaryTable()->fetchAll();
						
						$id_dictionary = Rand::getInteger(0, $dictionarySet->count());
					
						$newGame = new Games();
						
						/* Set timers + info and put data into database */
						$dataNewGame = array(
							'id_dictionary' => $id_dictionary,
							'date_creation' => date("Y-m-d\TH:i:s\Z", time()),
							'date_start' => date("Y-m-d\TH:i:s\Z", time() + 120),
							'date_find_limit' => date("Y-m-d\TH:i:s\Z", time() + 240),
							'rounds_count' => 0,
							'started' => 0,
							'finished' => 0,
						);
						$newGame->exchangeArray($dataNewGame);
						$this->getGamesTable()->saveGames($newGame);
						$newGameId = $this->getGamesTable()->getLastCreatedGameId();
						
						/* For each player, we must create link between them and the new game (UsersTable <= UsersGamesTable => GamesTable) */
						foreach ($players as $player) {
							$invitedFriendId = $this->getUsersTable()->getUserIdByLogin($player);
							
							$newUserGame = new UsersGames();
							
							$dataNewUserGame = array(
								'id_user' => $invitedFriendId,
								'id_game' => $newGameId,
								'score' => 0,
								'is_ready' => 0,
								'is_painter' => 0,
							);
							$newUserGame->exchangeArray($dataNewUserGame);
							$this->getUsersGamesTable()->saveUsersGames($newUserGame);
						}
						
						/* The user himself must have a link between his table and the game he created - he is ready and the painter by default */
						$dataNewUserGame = array(
							'id_user' => $userId,
							'id_game' => $newGameId,
							'score' => 0,
							'is_ready' => 1,
							'is_painter' => 1,
						);
						$newUserGame->exchangeArray($dataNewUserGame);
						$this->getUsersGamesTable()->saveUsersGames($newUserGame);
						
						/* Creation of the game succesful: go to the page of the new game */
						return $this->redirect()->toRoute('game', array('action' => 'play', 'id' => $newGameId));
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
		/* If the user isn't connected redirect to home */
		$nm_authInfo = new Container('authentification_info');
		
		if(!isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home', array('action' => 'signin'));
		}
	
		$info = '';
		
		/* 
		 * 0 <=> Error occured while loading data
		 * 1 <=> I must accept or decline
		 * 2 <=> I accepted to play, not the others
		 * 3 <=> I have to draw
		 * 4 <=> I have to wait the drawing
		 * 5 <=> I must guess the word behind the drawing
		 * 6 <=> The others must guess the word behind my drawing
		 * 7 <=> The game is finished
		 */
		$gameState = 0;
		
		/* The game id is defined by url: check it */
		$gameData = $this->getGamesTable()->fetchGameById($this->params()->fromRoute('id'));
		
		/* If the id exists */
		if (count($gameData) > 0) {
			$gameData = $gameData->current();
		
			/* Is the current user a player of this game? */
			$connectedUserGameData = $this->getUsersGamesTable()->fetchUserGameByIds($this->getUsersTable()->getUserIdByLogin($nm_authInfo->login), $gameData->id);
			
			/* If this is a player of this game */
			if (count($connectedUserGameData) > 0) {
				$connectedUserGameData = $connectedUserGameData->current();
			
				$usersId = $this->getUsersGamesTable()->getUsersIdOfGameById($gameData->id);
				$usersData = $this->getUsersTable()->fetchUsersById($usersId);
				
				$usersGamesData = $this->getUsersGamesTable()->fetchUsersGamesByIds($usersId, $gameData->id);
				
				/* We have to travel the sets more than one time */
				/* Because ResultSet Zend's iterators usages are uniques, we must save ResultSet data in arrays */
				/* Theses sets have a "toArray()" method, but it seems that it is not working */
				$arrayGameData = array();
				$arrayPainterData = array();
				$arrayUsersData = array();
				$arrayUsersGamesData = array();
				
				foreach ($gameData as $key => $value) {
					$arrayGameData[$key] = $value;
				}
				
				foreach ($usersData as $userData) {
					$arrayContent = array();
				
					foreach ($userData as $key => $value) {
						$arrayContent[$key] = $value;
					}
					array_push($arrayUsersData, $arrayContent);
				}
				
				foreach ($usersGamesData as $userGameData) {
					$arrayContent = array();
					
					foreach ($userGameData as $key => $value) {
						$arrayContent[$key] = $value;
					}
					array_push($arrayUsersGamesData, $arrayContent);
				}
				
				/* Determine game state */
				/* Am I ready? */
				$current_ready = $connectedUserGameData->is_ready == 1 ? true : false;
				
				/* Am I the painter? */
				$current_painter = $connectedUserGameData->is_painter == 1 ? true : false;
				
				/* Is everybody ready? */
				$not_ready_count = 0;

				foreach ($arrayUsersGamesData as $userGameData) {
					if ($userGameData['is_ready'] == 0) {
						$not_ready_count++;
					}
				}
				
				/* Look for the painter */
				$id_painter = 0;
				$id_usersGames_painter = 0;
				
				foreach ($arrayUsersGamesData as $userGameData) {
					if ($userGameData['is_painter'] == 1) {
						$id_usersGames_painter = $userGameData['id'];
						$id_painter = $userGameData['id_user'];
						break;
					}
				}
				
				foreach ($arrayUsersData as $userData) {
					if ($userData['id'] == $id_painter) {
						foreach ($userData as $key => $value) {
							$arrayPainterData[$key] = $value;
						}
						break;
					}
				}
				
				$currentTimeStamp = time();
				$startTimeStamp = strtotime($arrayGameData['date_start']);
				$findLimitTimeStamp = strtotime($arrayGameData['date_find_limit']);
				
				/* Are we before start time? */
				$before_start = ($currentTimeStamp < $startTimeStamp) ? true : false;
				
				/* Are we before find limit time? */
				$before_find_limit = ($currentTimeStamp < $findLimitTimeStamp) ? true : false;
				
				/* Assign value to game state variable, depending on results above-written */
				if (!$current_ready) {
					$gameState = 1;
				} else if ($not_ready_count != 0) {
					$gameState = 2;
				} else if ($before_start) {
					$gameState = $current_painter ? 3 : 4;
				} else if ($before_find_limit) {
					$gameState = $current_painter ? 6 : 5;
				} else {
					$gameState = 7;
				}
				
				/* Get and assign mysterious word to its variable */
				$mysterious_word = $this->getDictionaryTable()->getWordById($arrayGameData['id_dictionary']);
				
				/* Forms creations */
				$formAcceptInvitation = new AcceptInvitationForm();
				$formSuggestWord = new SuggestWordForm();
				$request = $this->getRequest();
				
				if ($request->isPost()) {
					$filterAcceptInvitation = new AcceptInvitationFormFilter();
					$formAcceptInvitation->setInputFilter($filterAcceptInvitation->getInputFilter());
					$formAcceptInvitation->setData($request->getPost());
					
					$filterSuggestWord = new SuggestWordFormFilter();
					$formSuggestWord->setInputFilter($filterSuggestWord->getInputFilter());
					$formSuggestWord->setData($request->getPost());
					
					/* The user must accept or decline the invitation */
					if ($gameState == 1 && $formAcceptInvitation->isValid()) {
						/* The user accepted */
						if (isset($formAcceptInvitation->getData()['submit-accept-invitation'])) {
							$data = array(
								'is_ready' => 1,
							);
							
							foreach ($arrayUsersGamesData as $userGameData) {							
								if ($userGameData['id_user'] == $connectedUserGameData->id_user) {
									$this->getUsersGamesTable()->editUsersGamesByIdWithData($userGameData['id'], $data);
									break;
								}
							}
							
							/* If he was the last to accept the game, launch the game */
							if ($not_ready_count == 1) {
								$data = array(
									'started' => 1,
									'date_start' => date("Y-m-d\TH:i:s\Z", time() + 120),
									'date_find_limit' => date("Y-m-d\TH:i:s\Z", time() + 240),
								);
								
								$this->getGamesTable()->editGamesByIdWithData($arrayGameData['id'], $data);
							}
							
							/* Reload page (reload data to print and/or the game state) */
							return $this->redirect()->toRoute('game', array('action' => 'play', 'id' => $arrayGameData['id']));
							
						} else {
							/* The user declined: destroy the game and the links between this game and the players */
							$this->getGamesTable()->deleteGamesById($arrayGameData['id']);
							$this->getUsersGamesTable()->deleteUsersGamesByGameId($arrayGameData['id']);
							
							return $this->redirect()->toRoute('member', array('action' => 'games', 'name' => $nm_authInfo->login));
						}
					}
					
					/* The user must guess a word */
					if ($gameState == 5 && $formSuggestWord->isValid()) {
						/* If he guessed right */
						if ($mysterious_word == $formSuggestWord->getData()['word']) {
							$data = array(
								'score' => $connectedUserGameData->score + 100,
							);
							
							$this->getUsersGamesTable()->editUsersGamesByIdWithData($connectedUserGameData->id, $data);
							
							/* Increment the number of rounds passed */
							$arrayGameData['rounds_count']++;
							
							/* If we already done 5 rounds, the game finished */
							if ($arrayGameData['rounds_count'] > 5) {
								$data = array(
									'date_start' => date("Y-m-d\TH:i:s\Z", 0),
									'date_find_limit' => date("Y-m-d\TH:i:s\Z", 0),
									'finished' => 1,
								);
							} else {
								/* If not, the "guesser" is the new "painter" and a new round start */
								$dictionarySet = $this->getDictionaryTable()->fetchAll();
						
								$id_dictionary = Rand::getInteger(0, $dictionarySet->count());
							
								$data = array(
									'id_dictionary' => $id_dictionary,
									'date_start' => date("Y-m-d\TH:i:s\Z", time() + 120),
									'date_find_limit' => date("Y-m-d\TH:i:s\Z", time() + 240),
									'rounds_count' => $arrayGameData['rounds_count'],
								);
							}							
							$this->getGamesTable()->editGamesByIdWithData($arrayGameData['id'], $data);
							
							/* Switch painter role */
							$this->getUsersGamesTable()->editUsersGamesByIdWithData($connectedUserGameData->id, array('is_painter' => 1));
							$this->getUsersGamesTable()->editUsersGamesByIdWithData($id_usersGames_painter, array('is_painter' => 0));
							
							/* Reload page (reload data to print and/or the game state) */
							return $this->redirect()->toRoute('game', array('action' => 'play', 'id' => $arrayGameData['id']));
						} else {
							$info = 'This is not "' . $formSuggestWord->getData()['word'] . '".';
						}
					}
				}
			} else {
				$info = 'You are not a player of this game.';
			}
		} else {
			$info = 'This game does not exist.';
		}
	
		return new ViewModel(array(
			'info' => $info,
			'form_accept_invitation' => isset($formAcceptInvitation) ? $formAcceptInvitation : false,
			'form_suggest_word' => isset($formSuggestWord) ? $formSuggestWord : false,
			'game_state' => $gameState,
			'mysterious_word' => isset($mysterious_word) ? $mysterious_word : false,
			'game_data' => isset($arrayGameData) ? $arrayGameData  : false,
			'painter_data' => isset($arrayPainterData) ? $arrayPainterData : false,
			'users_data' => isset($arrayUsersData) ? $arrayUsersData : false,
			'users_games_data' => isset($arrayUsersGamesData) ? $arrayUsersGamesData : false,
		));
    }
}