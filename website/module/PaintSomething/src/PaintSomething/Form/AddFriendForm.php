<?php
namespace PaintSomething\Form;

use Zend\Form\Form;

class AddFriendForm extends Form {

    public function __construct($name = null) {
	
        parent::__construct('add-friend');

        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'submit-add-friend',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Add friend',
                'id' => 'submit-add-friend',
            ),
        ));
    }
}