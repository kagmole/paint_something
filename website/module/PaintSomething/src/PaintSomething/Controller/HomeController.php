<?php
namespace PaintSomething\Controller;

use PaintSomething\Form\SignInForm;
use PaintSomething\Form\SignInFormFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractActionController {

    protected $usersTable;

	public function getUsersTable() {
        if (!$this->usersTable) {
            $sm = $this->getServiceLocator();
            $this->usersTable = $sm->get('PaintSomething\Model\UsersTable');
        }
        return $this->usersTable;
    }

    public function indexAction() {
    
    }
    
    public function signinAction() {
		$info = '';
	
		$form = new SignInForm();
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$filter = new SignInFormFilter();
			$form->setInputFilter($filter->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$input_login = $form->getData()['login'];
				$input_password = $form->getData()['password'];
				
				$db_password = $this->getUsersTable()->getUserPasswordByLogin($input_login);
				
				if ($db_password && $db_password == sha1($input_password)) {
					$_SESSION['id'] = $this->getUsersTable()->getUserIdByLogin($input_login);
				} else {
					$info = 'Unknown user or wrong password.';
				}
			}
		}
	
		return new ViewModel(array(
			'form' => $form,
			'info' => $info,
        ));
    }
    
    public function signupAction() {
    
    }
}