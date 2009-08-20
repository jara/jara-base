<?php
/**
 * Application bootstrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/**
     * Bootstrap autoloader for application resources
     * 
     * @return Zend_Application_Module_Autoloader
     */
	protected function _initAutoload()
    {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default_',
            'basePath'  => dirname(__FILE__),
        ));
        return $autoloader;
    } 

  	/**
     * Bootstrap the view doctype
     * 
     * @return void
     */
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_TRANSITIONAL');
    }
}

