<?php
namespace PaintSomething\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Friends implements InputFilterAwareInterface {

    public $id;
    public $id_user1;
    public $id_user2;
    public $date_creation;
    public $confirmed;
	
	protected $inputFilter;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->id_user1 = (isset($data['id_user1'])) ? $data['id_user1'] : null;
        $this->id_user2 = (isset($data['id_user2'])) ? $data['id_user2'] : null;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : null;
        $this->confirmed = (isset($data['confirmed'])) ? $data['confirmed'] : null;
    }
	
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Method 'setInputFilter' in model 'Friends' is not implemented yet");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'username',
                'required' => true,
                'filters'  => array(
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