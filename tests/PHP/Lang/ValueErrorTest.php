<?php

namespace PHP\Lang;

\ClassLoader::import('\PHP\Lang\ValueError');

/**
 * Test class for \PHP\Lang\ValueError.
 */
class ValueErrorTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Test an exception throw
	 */
	public function testThrow() {
		try {
			$value = -1;
			$expected = 'positive integer';
			throw new \PHP\Lang\ValueError($value, $expected);
			$this->fail('Exception not thrown!');
		} catch (\PHP\Lang\ValueError $e) {
			$this->assertNotEquals(false, \strpos($e->getMessage(), (string)$value),
					'Value ' . $expected . ' is not in message! Message was: ' . $e->getMessage());
			$this->assertNotEquals(false, \strpos($e->getMessage(), $expected),
					'Expected string ' . $expected . ' is not in message! Message was: ' . $e->getMessage());
		}
	}
}
