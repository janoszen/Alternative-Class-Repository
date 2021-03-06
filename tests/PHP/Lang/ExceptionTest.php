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
	
	/**
	 * Tests, if hashcodes work properly.
	 */
	function testHashCodeGeneration() {
		$o = new TestException();
		$o2 = new TestException();
		$this->assertNotEmpty($o->hashCode());
		$this->assertNotEmpty($o2->hashCode());
		$this->assertNotEquals($o->hashCode(), $o2->hashCode());
	}
	
	/**
	 * Test, if two objects are not equal by default.
	 */
	function testEquals() {
		$o1 = new TestException();
		$o2 = new TestException();
		$this->assertFalse($o1->equals($o2));
		$this->assertTrue($o1->equals($o1));
		$this->assertTrue($o2->equals($o2));
	}
	
	/**
	 * Tests, if the toString function converts so some non-empty string
	 */
	function testStringConversion() {
		$o = new TestException();
		$this->assertNotEmpty($o->toString());
		$this->assertNotEmpty((string)$o);
		$this->assertEquals((string)$o, $o->toString());
	}
}
