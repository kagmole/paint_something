<?php
namespace PaintSomething\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class UsersGamesTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
		
        return $resultSet;
    }
	
	public function fetchUserGameByIds($userId, $gameId) {
		$select = new Select();
		$select->from('users_games');
		$select->where("id_user=$userId AND id_game=$gameId");

		$resultSet = $this->tableGateway->selectWith($select);
	
		return $resultSet;
	}
	
	public function fetchUsersGamesByIds($usersId, $gameId) {
		$select = new Select();
		$select->from('users_games');
		$select->where("id_game=$gameId AND id_user IN (". implode(',', $usersId) .")");

		$resultSet = $this->tableGateway->selectWith($select);
	
		return $resultSet;
	}
	
	public function getGamesIdOfUserById($userId) {
		$select = new Select();
		$select->from('users_games');
		$select->columns(array('id_game'));
		$select->where("id_user=$userId");
		
		$resultSet = $this->tableGateway->selectWith($select);
		
		$gamesId = array();
		
		foreach($resultSet as $result) {
			array_push($gamesId, $result->id_game);
		}
		
		return $gamesId;
	}
	
	public function getUsersIdOfGameById($gameId) {
		$select = new Select();
		$select->from('users_games');
		$select->columns(array('id_user'));
		$select->where("id_game=$gameId");
		
		$resultSet = $this->tableGateway->selectWith($select);
		
		$usersId = array();
		
		foreach($resultSet as $result) {
			array_push($usersId, $result->id_user);
		}
		
		return $usersId;
	}
	
	public function deleteUsersGamesByGameId($gameId) {
		$where = new Where();
		$where->like('id_game', $gameId);
		
		$this->tableGateway->delete($where);
	}
	
	public function editUsersGamesByIdWithData($userGameId, $data) {
		$where = new Where();    
		$where->like('id', $userGameId);	
		
		$this->tableGateway->update($data, $where);
	}
	
	public function saveUsersGames($newUserGame) {
		$data = array(
			'id_user' => $newUserGame->id_user,
			'id_game' => $newUserGame->id_game,
			'score' => $newUserGame->score,
			'is_ready' => $newUserGame->is_ready,
			'is_painter' => $newUserGame->is_painter,
        );
	
		$this->tableGateway->insert($data);
	}
}