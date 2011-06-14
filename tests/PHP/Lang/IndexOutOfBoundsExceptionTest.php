<?php

namespace PHP\Lang;

\ClassLoader::import('\PHP\Lang\IndexOutOfBoundsException');

/**
 *  This class tests the functionality of \PHP\Lang\IndexOutOfBoundsException
 */
class IndexOutOfBoundsExceptionTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests throwing the exception with an offset.
	 */
	public function testThrowWithOffset() {
		try {
			$offset = 12;
			throw new \PHP\Lang\IndexOutOfBoundsException($offset);
			$this->fail('Exception not thrown!');
		} catch (\PHP\Lang\IndexOutOfBoundsException $e) {
			$this->assertNotEquals(false, \strpos($e->getMessage(), (string)$offset),
					'Offset ' . $offset . ' is not in message! Message was: ' . $e->getMessage());
		}
	}

	/**
	 * Tests throwing the exception without an offset
	 */
	public function testThrowWithoutOffset() {
		try {
			throw new \PHP\Lang\IndexOutOfBoundsException();
			$this->fail('Exception not thrown!');
		} catch (\PHP\Lang\IndexOutOfBoundsException $e) {
			$this->assertNotEquals('', $e->getMessage(), 'Message is empty!');
		}
	}
}
