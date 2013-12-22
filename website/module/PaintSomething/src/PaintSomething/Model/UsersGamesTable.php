<?php
namespace PaintSomething\Model;

use Zend\Db\Sql\Select;
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
}