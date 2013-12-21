<?php
namespace PaintSomething\Form;

use Zend\Form\Form;

class SignUpForm extends Form {

    public function __construct($name = null) {
	
        parent::__construct('sign-up');

		$this->add(array(
			'name' => 'email',
			'type' => 'Email',
		));
		$this->add(array(
            'name' => 'login',
            'type' => 'Text',
        ));
		$this->add(array(
            'name' => 'password',
            'type' => 'Password',
        ));
		$this->add(array(
            'name' => 'confirm-password',
            'type' => 'Password',
        ));
        $this->add(array(
            'name' => 'submit-sign-up',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Sign up',
                'id' => 'submit-sign-up',
            ),
        ));
    }
}