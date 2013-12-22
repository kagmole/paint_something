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
		/* Just show the view */
    }
    
    public function signinAction() {
		/* If user is still connected, redirect to the homepage */
		$nm_authInfo = new Container('authentification_info');
		
		if(isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home');
		}
		
		$info = '';
	
		/* Prepare the "Sign in" form */
		$form = new SignInForm();
		$request = $this->getRequest();
		
		/* If we got a POST request */
		if ($request->isPost()) {
			$filter = new SignInFormFilter();
			$form->setInputFilter($filter->getInputFilter());
			$form->setData($request->getPost());
			
			/* If the form is valid, according to the filter */
			if ($form->isValid()) {
				$input_login = $form->getData()['login'];
				$input_password = $form->getData()['password'];
				
				/* If the user does not exist, $db_password will be false */
				$db_password = $this->getUsersTable()->getUserPasswordByLogin($input_login);
				
				/* If the user exists and the password is correct */
				if ($db_password && $db_password == sha1($input_password)) {
					$nm_authInfo = new Container('authentification_info');
					$nm_authInfo->login = $input_login;
					
					/* Update last connection info */
					$this->getUsersTable()->editUsersByIdWithData($this->getUsersTable()->getUserIdByLogin($input_login), array('date_last_connection' => date("Y-m-d\TH:i:s\Z", time())));
					
					/* Go to profile page */
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
		/* If user is still connected, redirect to the homepage */
		$nm_authInfo = new Container('authentification_info');
		
		if(isset($nm_authInfo->login)){
			return $this->redirect()->toRoute('home');
		}
		
		$info = '';
		
		/* Prepare the "Sign up" form */
		$form = new SignUpForm();
		$request = $this->getRequest();
		
		/* If we got a POST request */
		if ($request->isPost()) {
			$filter = new SignUpFormFilter();
			$form->setInputFilter($filter->getInputFilter());
			$form->setData($request->getPost());
			
			/* If the form is valid, according to the filter */
			if ($form->isValid()) {
				/* The filter already checks if there are not empty */
				$input_email = $form->getData()['email'];
				$input_login = $form->getData()['login'];
				$input_password = $form->getData()['password'];
				$input_confirmPassword = $form->getData()['confirm-password'];
				
				/* If the login does not exist, $db_id will be -1 */
				$db_id = $this->getUsersTable()->getUserIdByLogin($input_login);
				
				/* The username is new to the database */
				if ($db_id == -1) {
					/* Check if the two passwords are the same */
					if ($input_password == $input_confirmPassword) {
						$data = array(
							'login' => $input_login,
							'password' => sha1($input_password),
							'email' => $input_email,
							'activated' => 1,
						);
						
						$this->getUsersTable()->saveUsersWithData($data);
						
						/* Save user, connect him and redirect him to his profile */
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
		/* Just show the view */
	}
	
	public function logoutAction(){
		/* Unset Zend Session Container for the authentification info */
		$nm_authInfo = new Container('authentification_info');
		
		if(isset($nm_authInfo->login)){
			unset($nm_authInfo->login);
		}
		
		/* Go to home */
		return $this->redirect()->toRoute('home');
	}
}