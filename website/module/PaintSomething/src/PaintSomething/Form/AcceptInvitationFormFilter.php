<?php
namespace PaintSomething\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class AcceptInvitationFormFilter implements InputFilterAwareInterface {
	
	protected $inputFilter;
	
	public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Method 'setInputFilter' in model 'Friends' is not implemented yet");
    }
	
	public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
			
			$this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}