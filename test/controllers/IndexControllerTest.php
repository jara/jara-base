<?
/**
 * IndexControllerTest - Test the default index controller
 * 
 * @author 	Ekerete Akpan
 */
require_once realpath(dirname(__FILE__) . '/../TestHelper.php');

/**
 * IndexController Test Case
 */
class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase {

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
	
	/**
	 * Tests IndexController->indexAction()
	 */
	public function testIndexAction() {
		$this->dispatch('/index/index');
		$this->assertController('index');
		$this->assertAction('index');
	}
	
	/**
	 * Test the default home page
	 */
	public function testShouldGetDefaultModuleIndexControllerAndIndexActionAsHome() {
		$this->dispatch();
		$this->assertModule('default');
		$this->assertController('index');
		$this->assertAction('index');
	}
	
	
}
?>
