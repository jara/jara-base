<?php

/**
 * IndexController - The default controller class
 * 
 * @author Ekerete Akpan 
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
		$this->view->menuLinks = array('about');
		$this->view->baseUrl = $this->getFrontController()->getBaseUrl();
	}

	/**
	 * The default action - show the home page
	 */
    public function indexAction() 
    {
    	
    }
    
	/**
	 * The about Jara page
	 */
    public function aboutAction() 
    {
        
    }
}
