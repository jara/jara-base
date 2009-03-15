<?
/**
 * Abstract controller test class
 * 
 * @author 	Ekerete Akpan
 */

/**
 * IndexController Test Case
 */
abstract class Jara_ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase {

	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		$this->bootstrap = array($this, 'appBootstrap' );
		parent::setUp ();		
	}

	/**
	 * Prepares the environment before running a test.
	 */
	public function appBootstrap() {
		$this->frontController->registerPlugin(new Initializer(APP_ENV));
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		
	}
	
}
