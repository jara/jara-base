<?php
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__) . '/../library'),
    get_include_path(),
)));

define('APPLICATION_ENV', 'test');
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
    
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();


/**
 * Base Controller Test Class
 * 
 * All controller tests should extend this
 */
abstract class BaseControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase {

    public function setUp() {
        $application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->bootstrap = array($application->getBootstrap(), 'bootstrap');
        return parent::setUp();
    }

    public function tearDown() {
        /* Tear Down Routine */
    }
}