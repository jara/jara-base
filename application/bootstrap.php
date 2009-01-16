<?php
/**
 * Jara Base Zend Framework project
 * 
 * @author Ekerete Akpan
 */

require_once 'Initializer.php';

// get the application include paths and tack them on to the system paths
$includePaths = Initializer::getIncludePaths(APP_ROOT);
array_push($includePaths, get_include_path());
set_include_path(join(PATH_SEPARATOR, $includePaths));

require_once 'Zend/Loader.php';

// Set up autoload.
Zend_Loader::registerAutoload(); 
 
// Prepare the front controller. 
$frontController = Zend_Controller_Front::getInstance(); 

// Change to 'production' parameter under production environemtn
$frontController->registerPlugin(new Initializer(APP_ENV));    

// Dispatch the request using the front controller. 
$frontController->dispatch();