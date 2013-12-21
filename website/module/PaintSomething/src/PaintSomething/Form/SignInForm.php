<?php
namespace PaintSomething\Form;

use Zend\Form\Form;

class SignInForm extends Form {

    public function __construct($name = null) {
	
        parent::__construct('sign-in');

		$this->add(array(
            'name' => 'login',
            'type' => 'Text',
        ));
		$this->add(array(
            'name' => 'password',
            'type' => 'Password',
        ));
        $this->add(array(
            'name' => 'submit-sign-in',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Sign in',
                'id' => 'submit-sign-in',
            ),
        ));
    }
}