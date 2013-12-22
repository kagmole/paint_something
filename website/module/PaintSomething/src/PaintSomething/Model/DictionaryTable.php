<?php
namespace PaintSomething\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class DictionaryTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
	
	public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        
        return $resultSet;
    }
	
	public function getWordById($id) {
		$select = new Select();
		$select->from('dictionary');
		$select->columns(array('word'));
		$select->where("id=$id");
		
		$resultSet = $this->tableGateway->selectWith($select);
		
		return $resultSet->current()->word;
	}
}