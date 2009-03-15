<?php

/**
 * Account_IndexController
 * 
 * @author Ekerete Akpan 
 */

class Account_IndexController extends Jara_Controller {

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
	 * The default action - show the profile page
	 */
    public function indexAction() {
    	
    }
}
