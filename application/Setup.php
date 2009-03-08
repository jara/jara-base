<?php
/**
 * Jara Base Zend Framework project
 * 
 * @author Ekerete Akpan
 */

if (!defined('APP_ROOT')) {
	define('APP_ROOT', realpath(dirname(dirname(__FILE__))));
}
if (!defined('APP_ENV')) {
    /* Change to 'production' under production environment */
	define('APP_ENV', 'development');
}

class Setup {
    
    /**
     * Get the application include paths
     * 
     * @param 	string 	$rootPath 	The application root path
     * @return 	array 	An array of include paths
     */
    public static function includePaths($rootPath) {
		$includePaths = array();
		$includePaths[] = $rootPath . DIRECTORY_SEPARATOR . 'library';
		
		$jaraModules = self::getAvailableModules($rootPath);		
		
		foreach ($jaraModules as $jaraMod) 
		{			
			$modulePath = $rootPath . DIRECTORY_SEPARATOR . 
						  'application' . DIRECTORY_SEPARATOR . 
						  $jaraMod . DIRECTORY_SEPARATOR;
			
			if (is_dir($modulePath . 'models')) 
			{
				$includePaths[] = $modulePath . 'models';
			}
		}
		
		return $includePaths;
    	
    }

    /**
     * Get all the available modules
     * 
     * @param 	string 	$rootPath 	The application root path
     * @return 	array
     */
    public static function getAvailableModules($rootPath) 
    {
	    $jaraModules = array();
		$jaraExclude = array('layouts');
		$jaraDirectories = new DirectoryIterator($rootPath. '/application');		
		
		foreach ($jaraDirectories as $jaraDir) {
			if (!$jaraDir->isDot() && !$jaraDir->isFile() && !in_array($jaraDir, $jaraExclude)) {
				$jaraModules[] = (string)$jaraDir;
			}
		}
		
		return $jaraModules;
    }  

    /**
     * Start the bootstrap process
     */
    public static function startBootstrap() {		
    	self::setupIncludePaths();
        self::setupAutoload();
    }

    /**
    * get the application include paths and tack them on to the system paths
    */
    private static function setupIncludePaths() {
        $includePaths = self::includePaths(APP_ROOT);
        array_push($includePaths, get_include_path());
        set_include_path(join(PATH_SEPARATOR, $includePaths));
    }

    /**
    * setup autoload
    */
    private static function setupAutoload() {
        require_once 'Zend/Loader.php';
        Zend_Loader::registerAutoload(); 
    }

    /**
    * Prepare the front controller, register the initialiser and dispatch
    */
    public static function dispatchJara() {
        require_once 'Initializer.php';
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->registerPlugin(new Initializer(APP_ENV)); 
        $frontController->dispatch();  
    }

}