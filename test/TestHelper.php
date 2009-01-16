<?php

define('APP_ENV', 'test');

require_once realpath(dirname(__FILE__) . '/../application/Initializer.php');

// get the application include paths and tack them on to the system paths
$includePaths = Initializer::getIncludePaths(APP_ROOT);
array_push($includePaths, get_include_path());
set_include_path(join(PATH_SEPARATOR, $includePaths));

require_once 'Zend/Loader.php';

// Set up autoload.
Zend_Loader::registerAutoload(); 