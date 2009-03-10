<?php

/**
 * IndexController - The default controller class
 * 
 * @author Ekerete Akpan 
 */

class IndexController extends Jara_Controller {

	/**
	 * Controller init method
	 * 
	 * This method is run before the specified controller action.
	 * Put all common controller stuff in here 
	 */
	public function init() {
		parent::init();
		$this->view->menuLinks = array('about');
	}

	/**
	 * The default action - show the home page
	 */
    public function indexAction() {
    	
    }
    
	/**
	 * The about Jara page
	 */
    public function aboutAction() {
        
    }
    
}
