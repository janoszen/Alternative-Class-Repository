<?php

namespace PHP\Lang;

\ClassLoader::import('\PHP\Lang\TypeError');

/**
 * Test class for \PHP\Lang\TypeError.
 */
class TypeErrorTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Test throwing with a class
	 */
	public function testWithClass() {
		try {
			$class = new \stdClass();
			$expected = 'string';
			throw new \PHP\Lang\TypeError($class, $expected);
			$this->fail('Exception not thrown!');
		} catch (\PHP\Lang\TypeError $e) {
			$this->assertNotEquals(false, \strpos($e->getMessage(), \get_class($class)),
					'Class name ' . \get_class($class) . ' is not in message! Message was: ' . $e->getMessage());
			$this->assertNotEquals(false, \strpos($e->getMessage(), $expected),
					'Expected type ' . $expected . ' is not in message! Message was: ' . $e->getMessage());
		}
	}

	/**
	 * Test with a base type.
	 */
	public function testWithBaseType() {
		try {
			$type = 17;
			$expected = 'string';
			throw new \PHP\Lang\TypeError($type, $expected);
			$this->fail('Exception not thrown!');
		} catch (\PHP\Lang\TypeError $e) {
			$this->assertNotEquals(false, \strpos($e->getMessage(), \gettype($type)),
					'Class name ' . \gettype($type) . ' is not in message! Message was: ' . $e->getMessage());
			$this->assertNotEquals(false, \strpos($e->getMessage(), $expected),
					'Expected type ' . $expected . ' is not in message! Message was: ' . $e->getMessage());
		}
	}
}
