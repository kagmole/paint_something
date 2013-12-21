<?php
namespace PaintSomething\Form;

use Zend\Form\Form;

class EditMemberForm extends Form {

    public function __construct($name = null) {
	
        parent::__construct('edit-member');

		$this->add(array(
            'name' => 'email',
            'type' => 'Text',
        ));
		$this->add(array(
            'name' => 'new-password',
            'type' => 'Password',
        ));
		$this->add(array(
            'name' => 'confirm-password',
            'type' => 'Password',
        ));
        $this->add(array(
            'name' => 'submit-edit-member',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Save changes',
                'id' => 'submit-edit-member',
            ),
        ));
    }
}