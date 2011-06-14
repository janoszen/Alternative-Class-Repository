<?php

namespace PHP\Lang;

\ClassLoader::import('\PHP\Lang\Exception');

/**
 * This class tests the functionality of \PHP\Lang\Exception
 */
class ExceptionTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests the throw of an exception with message
	 */
	public function testThrow() {
		try {
			throw new \PHP\Lang\Exception('test');
			$this->fail('Exception was not thrown!');
		} catch (\PHP\Lang\Exception $e) {
			$this->assertEquals('test', $e->getMessage(), 'Message did not arrive intact!');
		}
	}
}
