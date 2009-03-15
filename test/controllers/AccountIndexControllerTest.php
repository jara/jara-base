<?
/**
 * AccountControllerTest - Test the account module index controller
 * 
 * @author 	Ekerete Akpan
 */
require_once realpath(dirname(__FILE__) . '/../TestHelper.php');

/**
 * IndexController Test Case
 */
class AccountIndexControllerTest extends Jara_ControllerTestCase {
	
		/**
	 * Tests IndexController->indexAction()
	 */
	public function testIndexAction() {
		$this->dispatch('/account/index');
		$this->assertModule('account');
		$this->assertController('index');
		$this->assertAction('index');
		
		$this->dispatch('/account');
		$this->assertModule('account');
		$this->assertController('index');
		$this->assertAction('index');
	}
	
}