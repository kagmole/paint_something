<?php
namespace PaintSomething\Model;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class UsersTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        
        return $resultSet;
    }
	
	public function fetchUserByLogin($login) {
		$where = new Where();    
		$where->like('login', $login);
	
		$resultSet = $this->tableGateway->select($where);
		
		return $resultSet;
	}
	
	public function fetchUsersById($ids) {
		$select = new Select();
		$select->from('users');
		$select->where('id IN ('. implode(',', $ids) .')');
		
		$resultSet = $this->tableGateway->selectWith($select);
		
		return $resultSet;
	}
	
	public function getUserIdByLogin($login) {
		$select = new Select();
		$select->from('users');
		$select->columns(array('id'));
		$select->where->like('login', $login);
		
		$resultSet = $this->tableGateway->selectWith($select);
		
		if ($resultSet->count() > 0) {
			return $resultSet->current()->id;
		} else {
			return -1;
		}
	}
}