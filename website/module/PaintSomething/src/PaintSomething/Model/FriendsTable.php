<?php
namespace PaintSomething\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class FriendsTable {

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function getFriendsIdOfUserById($userId) {
		$selectFriends = new Select();
		$selectFriends->from('friends');
		$selectFriends->columns(array('id_user1'));
		$selectFriends->where("id_user2=$userId");
		
		$selectFriendsBis = new Select();
		$selectFriendsBis->from('friends');
		$selectFriendsBis->columns(array('id_user2'));
		$selectFriendsBis->where("id_user1=$userId");
		
		$selectFriends->combine($selectFriendsBis);
		
		$resultSetFriends = $this->tableGateway->selectWith($selectFriends);
		
		$friendsId = array();
		
		foreach($resultSetFriends as $result) {
			array_push($friendsId, $result->id_user1);
		}
		
		return $friendsId;
    }
	
	public function saveFriends(Friends $friend) {
        $data = array(
            'id_user1' => $friend->id_user1,
			'id_user2' => $friend->id_user2,
            'confirmed' => $friend->confirmed,
        );
		
		$this->tableGateway->insert($data);
    }
}