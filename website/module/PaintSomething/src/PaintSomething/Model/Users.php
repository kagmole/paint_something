<?php
namespace PaintSomething\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Users implements InputFilterAwareInterface {

    public $id;
    public $login;
    public $password;
    public $email;
    public $date_creation;
    public $date_last_connection;
    public $activated;
	
	protected $inputFilter;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->login = (isset($data['login'])) ? $data['login'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : null;
        $this->date_last_connection = (isset($data['date_last_connection'])) ? $data['date_last_connection'] : null;
        $this->activated = (isset($data['activated'])) ? $data['activated'] : null;
    }
	
	public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Method 'setInputFilter' in model 'Friends' is not implemented yet");
    }
	
	public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'email',
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
			$inputFilter->add($factory->createInput(array(
				'name' => 'new-password',
				'required' => false,
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
			$inputFilter->add($factory->createInput(array(
				'name' => 'confirm-password',
				'required' => false,
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