<?php

/**
 * IndexController - The default controller class
 * 
 * @author
 * @version 
 */

class IndexController extends Zend_Controller_Action 
{

	/**
	 * Controller init method
	 * 
	 * This method is run before the specified controller action.
	 * Put all common controller stuff in here 
	 */
	public function init() 
	{
		$this->view->menuLinks = array('home', 'about', 'contact');
	}

	/**
	 * The default action - show the home page
	 */
    public function indexAction() 
    {
        // TODO Auto-generated IndexController::indexAction() action
    }
}
