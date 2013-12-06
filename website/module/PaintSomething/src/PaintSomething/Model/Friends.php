<?php
namespace PaintSomething\Model;

class Friends {

    public $id;
    public $id_user1;
    public $id_user2;
    public $date_creation;
    public $confirmed;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->id_user1 = (isset($data['id_user1'])) ? $data['id_user1'] : null;
        $this->id_user2 = (isset($data['id_user2'])) ? $data['id_user2'] : null;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : null;
        $this->confirmed = (isset($data['confirmed'])) ? $data['confirmed'] : null;
    }
}