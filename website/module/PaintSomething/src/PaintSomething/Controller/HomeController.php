<?php
namespace PaintSomething\Controller;

use PaintSomething\Form\SignInForm;
use PaintSomething\Form\SignInFormFilter;
use PaintSomething\Form\SignUpForm;
use PaintSomething\Form\SignUpFormFilter;
use PaintSomething\Model\Users;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
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
		// if user is still connected, redirect to the homepage
		$nm_authInfo = new Container('authentification_info');
		if(isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home');
		}
		
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
					$nm_authInfo = new Container('authentification_info');
					$nm_authInfo->login = $input_login;
					
					return $this->redirect()->toRoute('member', array('name' => $input_login));
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
		// if user is still connected, redirect to the homepage
		$nm_authInfo = new Container('authentification_info');
		if(isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home');
		}
		
		$info = '';
		
		$form = new SignUpForm();
		$request = $this->getRequest();
		
		if ($request->isPost()) {
			$filter = new SignUpFormFilter();
			$form->setInputFilter($filter->getInputFilter());
			$form->setData($request->getPost());
			
			if ($form->isValid()) {
				$input_email = $form->getData()['email'];
				$input_login = $form->getData()['login'];
				$input_password = $form->getData()['password'];
				$input_confirmPassword = $form->getData()['confirm-password'];
				
				$db_id = $this->getUsersTable()->getUserIdByLogin($input_login);
				
				if ($db_id == -1) {
					if ($input_password == $input_confirmPassword) {
						$data = array(
							'login' => $input_login,
							'password' => sha1($input_password),
							'email' => $input_email,
							'activated' => 1,
						);
						
						$this->getUsersTable()->saveUsersWithData($data);
						
						$nm_authInfo = new Container('authentification_info');
						$nm_authInfo->login = $input_login;
					
						return $this->redirect()->toRoute('member', array('name' => $input_login));
					} else {
						$info = 'The two passwords were not the same.';
					}
				} else {
					$info = 'This username is already taken.';
				}
			}
		}
		
		return new ViewModel(array(
			'form' => $form,
			'info' => $info,
        ));
    }
	
	public function aboutAction(){
		
	}
	
	public function logoutAction(){
	
		$nm_authInfo = new Container('authentification_info');
		if(isset($nm_authInfo->login)){
			unset($nm_authInfo->login);
		}
		
		return $this->redirect()->toRoute('home');
	}
}