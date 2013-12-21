<?php
namespace PaintSomething\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GameController extends AbstractActionController {

    public function indexAction() {
		
    }
    
    public function newAction() {
    
    }
    
    public function playAction() {
		return new ViewModel(array(
			'gameId'=>$this->params()->fromRoute('id'),
		));
    }

}