<?php
namespace PaintSomething\Model;

class Dictionary {

    public $id;
    public $word;
    public $difficulty;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->word = (isset($data['word'])) ? $data['word'] : null;
        $this->difficulty = (isset($data['difficulty'])) ? $data['difficulty'] : null;
    }
}