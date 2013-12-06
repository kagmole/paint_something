<?php
namespace PaintSomething\Model;

class UsersGames {

    public $id;
    public $id_user;
    public $id_game;
    public $score;
    public $is_ready;
    public $is_painter;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->id_user = (isset($data['id_user'])) ? $data['id_user'] : null;
        $this->id_game = (isset($data['id_game'])) ? $data['id_game'] : null;
        $this->score = (isset($data['score'])) ? $data['score'] : null;
        $this->is_ready = (isset($data['is_ready'])) ? $data['is_ready'] : null;
        $this->is_painter = (isset($data['is_painter'])) ? $data['is_painter'] : null;
    }
}