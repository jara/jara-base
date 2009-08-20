<?php
/**
 * @group controllers
 */

require_once realpath(dirname(__FILE__) . '/../../TestHelper.php');

class IndexControllerTest extends BaseControllerTestCase {

    public function setUp() {
    	parent::setUp();
    }

    public function tearDown() {
    	parent::tearDown();
    }

    public function testShouldGetIndexPage() {
        $this->dispatch('/');
        $this->assertAction('index');
    }
    
 	public function testShouldGetAboutPage() {
        $this->dispatch('/index/about');
        $this->assertController('index');
        $this->assertAction('about');
    }
    
	public function testShouldGetAboutPageWithStaticRoute() {
        $this->dispatch('/about');
        $this->assertModule('default');
        $this->assertController('index');
        $this->assertAction('about');
    }
    
	public function testShouldGetContactPage() {
        $this->dispatch('/index/contact-us');
        $this->assertModule('default');
        $this->assertController('index');
        $this->assertAction('contact-us');
    }
    
	public function testShouldGetContactPageWithStaticRoute() {
        $this->dispatch('/contact-us');
        $this->assertModule('default');
        $this->assertController('index');
        $this->assertAction('contact-us');
    }
}
