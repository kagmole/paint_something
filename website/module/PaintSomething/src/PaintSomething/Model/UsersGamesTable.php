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
}