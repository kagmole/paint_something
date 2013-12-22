<?php
namespace PaintSomething\Form;

use Zend\Form\Form;

class AcceptInvitationForm extends Form {

    public function __construct($name = null) {
	
        parent::__construct('accept-invitation');

        $this->add(array(
            'name' => 'submit-accept-invitation',
            'type' => 'Submit',
            'attributes' => array(
				'value' => 'Accept',
                'id' => 'submit-accept-invitation',
            ),
        ));
		$this->add(array(
            'name' => 'submit-decline-invitation',
            'type' => 'Submit',
            'attributes' => array(
				'value' => 'Decline',
                'id' => 'submit-decline-invitation',
            ),
        ));
    }
}