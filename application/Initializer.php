<?php
/**
 * Jara Base Zend Framework project
 * 
 * @author  Ekerete Akpan
 */

if (!defined('APP_ROOT')) {
	define('APP_ROOT', realpath(dirname(dirname(__FILE__))));
}
if (!defined('APP_ENV')) {
	define('APP_ENV', 'development');
}

require_once 'Zend/Controller/Plugin/Abstract.php';
require_once 'Zend/Controller/Front.php';
require_once 'Zend/Controller/Request/Abstract.php';
require_once 'Zend/Controller/Action/HelperBroker.php';

/**
 * 
 * Initializes configuration depndeing on the type of environment 
 * (test, development, production, etc.)
 *  
 * This can be used to configure environment variables, databases, 
 * layouts, routers, helpers and more
 *   
 */
class Initializer extends Zend_Controller_Plugin_Abstract
{
    /**
     * @var Zend_Config
     */
    protected static $_config;

    /**
     * @var string Current environment
     */
    protected $_env;

    /**
     * @var Zend_Controller_Front
     */
    protected $_front;

    /**
     * @var string Path to application root
     */
    protected $_root;

    /**
     * Constructor
     *
     * Initialize environment, root path, and configuration.
     * 
     * @param  string $env 
     * @param  string|null $root 
     * @return void
     */
    public function __construct($env, $root = null)
    {
        $this->_setEnv($env);
        if (null === $root) {
            $root = realpath(dirname(__FILE__) . '/../');
        }
        $this->_root = $root;

        $this->initPhpConfig();
        
        $this->_front = Zend_Controller_Front::getInstance();
        
        // set the test environment parameters
        if ($env == 'test') {
			// Enable all errors so we'll know when something goes wrong. 
			error_reporting(E_ALL | E_STRICT);  
			ini_set('display_startup_errors', 1);  
			ini_set('display_errors', 1); 

			$this->_front->throwExceptions(true);  
        }
    }

    /**
     * Initialize environment
     * 
     * @param  string $env 
     * @return void
     */
    protected function _setEnv($env) 
    {
		$this->_env = $env;    	
    }
    

    /**
     * Initialize PHP configuration
     * 
     * @return void
     */
    public function initPhpConfig()
    {
    	date_default_timezone_set('UTC');
    }
    
    /**
     * Route startup
     * 
     * @return void
     */
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
       	$this->initDb();
        $this->initHelpers();
        $this->initView();
        $this->initPlugins();
        $this->initRoutes();
        $this->initControllers();
    }
    
    /**
     * Initialize data bases
     * 
     * @return void
     */
    public function initDb()
    {
    	
    }

    /**
     * Initialize action helpers
     * 
     * @return void
     */
    public function initHelpers()
    {
    	// register the default action helpers
    	Zend_Controller_Action_HelperBroker::addPath('../application/default/helpers', 'Zend_Controller_Action_Helper');
    }
    
    /**
     * Initialize view 
     * 
     * @return void
     */
    public function initView()
    {
		// Bootstrap layouts
		Zend_Layout::startMvc(array(
		    'layoutPath' => $this->_root .  '/application/layouts',
		    'layout' => 'main'
		));
    	
    }
    
    /**
     * Initialize plugins 
     * 
     * @return void
     */
    public function initPlugins()
    {
    	
    }
    
    /**
     * Initialize routes
     * 
     * @return void
     */
    public function initRoutes()
    {
    	$router = $this->_front->getRouter();
    	$pageRoute = new Zend_Controller_Router_Route(
    		':action',
    		array('module' => 'default', 'controller' => 'index')
    	);    	   	
		$router->addRoute('page', $pageRoute);
    }

    /**
     * Initialize Controller paths 
     * 
     * @return void
     */
    public function initControllers()
    {
    	$jaraModules = self::getAvailableModules($this->_root);
    	foreach ($jaraModules as $module) {
    		$this->_front->addControllerDirectory($this->_root . "/application/{$module}/controllers", $module);
    	}
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
     * Get the application include paths
     * 
     * @param 	string 	$rootPath 	The application root path
     * @return 	array 	An array of include paths
     */
    public static function getIncludePaths($rootPath) {
		$includePaths = array('library');
		
		$jaraModules = self::getAvailableModules($rootPath);		
		
		foreach ($jaraModules as $jaraMod) 
		{			
			$modulePath = $rootPath . DIRECTORY_SEPARATOR . $jaraMod . DIRECTORY_SEPARATOR;
			
			if (is_dir($modulePath . 'models')) 
			{
				$includePaths[] = $modulePath . 'models';
			}
		}
		
		return $includePaths;
    	
    }
    
}
?>
