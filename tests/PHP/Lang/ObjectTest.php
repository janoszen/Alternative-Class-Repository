<?php

namespace PHP\Lang;

\ClassLoader::import('\PHP\Lang\Object');

/**
 * This class tests the functionality of \PHP\Lang\Object
 */
class ObjectTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests, if hashcodes work properly.
	 */
	function testHashCodeGeneration() {
		$o = new TestObject();
		$this->assertNotEmpty($o->hashCode());
		$o2 = clone $o;
		$this->assertNotEmpty($o2->hashCode());
		$this->assertNotEquals($o->hashCode(), $o2->hashCode());
	}
	
	/**
	 * Test, if two objects are not equal by default.
	 */
	function testEquals() {
		$o1 = new TestObject();
		$o2 = new TestObject();
		$this->assertFalse($o1->equals($o2));
		$this->assertTrue($o1->equals($o1));
		$this->assertTrue($o2->equals($o2));
	}
	
	/**
	 * Tests, if the toString function converts so some non-empty string
	 */
	function testStringConversion() {
		$o = new TestObject();
		$this->assertNotEmpty($o->toString());
		$this->assertNotEmpty((string)$o);
		$this->assertEquals((string)$o, $o->toString());
	}
}