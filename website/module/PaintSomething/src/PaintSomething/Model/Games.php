<?php
namespace PaintSomething\Model;

class Games {

    public $id;
	public $id_dictionary;
    public $date_creation;
    public $date_start;
    public $date_find_limit;
	public $rounds_count;
    public $started;
    public $finished;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
		$this->id_dictionary = (isset($data['id_dictionary'])) ? $data['id_dictionary'] : null;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : null;
        $this->date_start = (isset($data['date_start'])) ? $data['date_start'] : null;
        $this->date_find_limit = (isset($data['date_find_limit'])) ? $data['date_find_limit'] : null;
		$this->rounds_count = (isset($data['rounds_count'])) ? $data['rounds_count'] : null;
        $this->started = (isset($data['started'])) ? $data['started'] : null;
        $this->finished = (isset($data['finished'])) ? $data['finished'] : null;
    }
}