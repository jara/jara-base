<?php
/**
 * AllTests - A Test Suite for your Application 
 * 
 * @author
 * @version 
 */
require_once realpath(dirname(__FILE__) . '/TestHelper.php');

foreach (AllTests::getTestFiles() as $match) {
	require_once $match;
}

/**
 * AllTests class - aggregates all tests of this project
 */
class AllTests extends PHPUnit_Framework_TestSuite {
	
	/**
	 * Constructs the test suite handler.
	 */
	public function __construct() {
		$this->setName ( 'AllTests' );
		
		foreach (AllTests::getTestFiles() as $match) {
			$testName = $match->getFilename();
			$this->addTestSuite(str_replace('.php', '', $testName));
		}
	
	}
	
	/**
	 * Creates the suite.
	 */
	public static function suite() {
		return new self ( );
	}
	
	/**
	 * Loop throught the test directory and return test  file matches
	 */
	public static function getTestFiles() {
		$dir = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__FILE__)));
		return new RegexIterator($dir, '/Test.php$/');
	}
}

