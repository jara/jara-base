<?php

class Jara_Plugin_StaticRoutes extends Zend_Controller_Plugin_Abstract
{
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        $dispatcher = Zend_Controller_Front::getInstance()->getDispatcher();
      	
      	$defaultController = $dispatcher->getDefaultControllerClass($request);   	
      	$controllerClass = $dispatcher->loadClass($defaultController);
      	$class = new ReflectionClass($controllerClass);
      	
      	if ($class) 
      	{
	     	$methods = $class->getMethods();
	     	$this->_addStaticRoutes($methods, $defaultController);		  	
     	} 
    }
    
	/**
     * Add the static routes to the router
     * 
     * @param 	array 	$methods 	The class methods for the default controller
     */
    protected function _addStaticRoutes($methods) 
    {
    	if (!is_array($methods) || empty($methods)) 
    	{
    		return false;
    	}
    	$router = Zend_Controller_Front::getInstance()->getRouter();
  
    	foreach ($methods as $method) 
    	{
		     if ($method->isPublic() && $this->_isAction($method) && !$this->_isDefaultAction($method))
		     {
		       $action = $this->_dasherise($method->getName());
		       $router->addRoute($action, $this->_pageRoute($action));
	   		}
	  	}
	  	$router->addRoute('home', $this->_pageRoute($this->_nameForDefault('action')));
    }
    
    /**
     * Create a new static route
     * 
     * @param 	string 	$action
     * @return 	Zend_Controller_Router_Route_Static
     */
    protected function _pageRoute($action) 
    {
    	return new Zend_Controller_Router_Route_Static(
	       $action,
	       array(
	       	'module' => $this->_nameForDefault('module'), 
	       	'controller' => $this->_nameForDefault('controller'), 
	       	'action' => $action
	       )
     	); 
    }
    
    protected function _isDefaultAction($method) 
    {    	
    	return ($this->_dasherise($method->getName()) == $this->_nameForDefault('action'));
    }
    
    protected function _isAction($method) 
    {
    	return (preg_match('/Action/', $method->getName()));
    }
    
    /**
     * Gets the default name for the controller, action and module
     * 
     * @param 	string	$segment
     * @return 	string
     */
    protected function _nameForDefault($segment) 
    {
    	$front = Zend_Controller_Front::getInstance();
    	$segment = ucfirst(trim($segment));
    	if ($segment == 'Controller') {
    		$segment .= 'Name';
    	}
    	$method = 'getDefault' . $segment;
    	return $front->{$method}();
    }
    
    /**
     * Uses Zend's inflector rules to convert from class names to url segments
     * 
     * @param 	string $name
     * @return 	string
     */
    protected function _dasherise($name) 
    {
    	$name = str_replace('Action', '', $name);
    	$inflector = new Zend_Filter_Inflector(':name');
    	$inflector->setRules(array(
		    ':name'  => array('Word_CamelCaseToDash', 'StringToLower')
		));
		return $inflector->filter(array('name' => $name));
    }

}