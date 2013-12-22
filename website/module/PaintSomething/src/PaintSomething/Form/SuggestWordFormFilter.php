<?php
namespace PaintSomething\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class SuggestWordFormFilter implements InputFilterAwareInterface {
	
	protected $inputFilter;
	
	public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Method 'setInputFilter' in model 'Friends' is not implemented yet");
    }
	
	public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'word',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            )));
			
			$this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}