<?php
namespace PaintSomething\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class NewGameFormFilter implements InputFilterAwareInterface {
	
	protected $inputFilter;
	
	public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Method 'setInputFilter' in model 'Friends' is not implemented yet");
    }
	
	public function generateCheckboxesInputFilterByCount($count) {
		$inputFilter = new InputFilter();
		$factory = new InputFactory();
		
		for ($i = 0; $i < $count; $i++) {
			$inputFilter->add($factory->createInput(array(
				'name' => 'choice' . $i,
				'required' => false,
			)));
		}
		
		$this->inputFilter = $inputFilter;
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