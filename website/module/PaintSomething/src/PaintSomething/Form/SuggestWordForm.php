<?php
namespace PaintSomething\Form;

use Zend\Form\Form;

class SuggestWordForm extends Form {

    public function __construct($name = null) {
	
        parent::__construct('suggest-word');

		$this->add(array(
            'name' => 'word',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'submit-suggest-word',
            'type' => 'Submit',
            'attributes' => array(
				'value' => 'Suggest a word',
                'id' => 'submit-suggest-word',
            ),
        ));
    }
}