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
class DefaultIndexControllerTest extends Jara_ControllerTestCase {

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
	
	/**
	 * Test default route to about page
	 */
	public function testShouldGetAboutPageWithDefaulRoute() {
		$this->dispatch('/index/about');
		$this->assertController('index');
		$this->assertAction('about');
	}
	
	/**
	 * Test page route to about page
	 */
	public function testShouldGetAboutPageWithPageRoute() {
		$this->dispatch('about');
		$this->assertController('index');
		$this->assertAction('about');
	}
	
}