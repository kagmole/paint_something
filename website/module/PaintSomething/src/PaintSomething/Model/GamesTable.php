<?php
namespace PaintSomething\Model;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class GamesTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
	
	public function fetchGameById($gameId) {
		$where = new Where();    
		$where->like('id', $gameId);
	
		$resultSet = $this->tableGateway->select($where);
		
		return $resultSet;
	}
	
	public function fetchPendingGamesById($ids) {
		$select = new Select();
		$select->from('games');
		$select->where('started=0 AND finished=0');
		$select->where('id IN ('. implode(',', $ids) .')');
		
		$resultSet = $this->tableGateway->selectWith($select);
		
		return $resultSet;
	}
	
	public function fetchRunningGamesById($ids) {
		$select = new Select();
		$select->from('games');
		$select->where('started=1 AND finished=0');
		$select->where('id IN ('. implode(',', $ids) .')');
		
		$resultSet = $this->tableGateway->selectWith($select);
		
		return $resultSet;
	}
	
	public function fetchFinishedGamesById($ids) {
		$select = new Select();
		$select->from('games');
		$select->where('started=1 AND finished=1');
		$select->where('id IN ('. implode(',', $ids) .')');
		
		$resultSet = $this->tableGateway->selectWith($select);
		
		return $resultSet;
	}
	
	public function getLastCreatedGameId() {
		$select = new Select();
		$select->from('games');
		$select->columns(array('id' => new Expression('MAX(id)')));
		$select->where('1');
		
		$resultSet = $this->tableGateway->selectWith($select);
		
		return $resultSet->current()->id;
	}
	
	public function deleteGamesById($gameId) {
		$where = new Where();
		$where->like('id', $gameId);
		
		$this->tableGateway->delete($where);
	}
	
	public function editGamesByIdWithData($gameId, $data) {
		$where = new Where();    
		$where->like('id', $gameId);	
		
		$this->tableGateway->update($data, $where);
	}
	
	public function saveGames($newGame) {
		$data = array(
			'id_dictionary' => $newGame->id_dictionary,
			'date_creation' => $newGame->date_creation,
			'date_start' => $newGame->date_start,
			'date_find_limit' => $newGame->date_find_limit,
			'rounds_count' => $newGame->rounds_count,
			'started' => $newGame->started,
			'finished' => $newGame->finished,
        );
	
		$this->tableGateway->insert($data);
	}
}