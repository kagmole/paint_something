<?php
namespace PaintSomething\Model;

use Zend\Db\Sql\Select;
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
}