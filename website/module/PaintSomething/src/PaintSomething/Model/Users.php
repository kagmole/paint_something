<?php
namespace PaintSomething\Model;

class Users {

    public $id;
    public $login;
    public $password;
    public $email;
    public $date_creation;
    public $date_last_connection;
    public $activated;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->login = (isset($data['login'])) ? $data['login'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : null;
        $this->date_last_connection = (isset($data['date_last_connection'])) ? $data['date_last_connection'] : null;
        $this->activated = (isset($data['activated'])) ? $data['activated'] : null;
    }
}