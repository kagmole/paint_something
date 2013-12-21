<?php
namespace PaintSomething\Form;

use Zend\Form\Form;

class NewGameForm extends Form {

    public function __construct($name = null) {
	
        parent::__construct('new-game');

        $this->add(array(
            'name' => 'submit-new-game',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Create a new game',
                'id' => 'submit-new-game',
            ),
        ));
    }
}