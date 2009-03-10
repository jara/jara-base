<?php
/**
 * Jara Base Zend Framework starter application
 *
 * @category   	Jara
 * @package    	Jara_Controller
 * @author 		Ekerete Akpan
 */

abstract class Jara_Controller extends Zend_Controller_Action {
	
	/**
	 * Controller init method
	 * 
	 * This method is run before the specified controller action.
	 * Put all common controller stuff in here 
	 */
	public function init() {
		parent::init();
		$this->view->baseUrl = $this->getFrontController()->getBaseUrl();
	}
	
}