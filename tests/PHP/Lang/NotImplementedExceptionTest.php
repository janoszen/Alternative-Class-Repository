<?php

namespace PHP\Lang;

\ClassLoader::import('\PHP\Lang\NotImplementedException');

/**
 * Test class for \PHP\Lang\NotImplementedException.
 */
class NotImplementedExceptionTest extends \PHPUnit_Framework_TestCase {
	/**
	 * This function tests the exception with a given feature name
	 */
	public function testWithFeature() {
		try {
			$feature = 'some feature';
			throw new \PHP\Lang\NotImplementedException($feature);
			$this->fail('Exception not thrown!');
		} catch (\PHP\Lang\NotImplementedException $e) {
			$this->assertNotEquals(false, \strpos($e->getMessage(), (string)$feature),
					'Feature ' . $feature . ' is not in message! Message was: ' . $e->getMessage());
		}
	}

	/**
	 * Tests the exception without a specific feature
	 */
	public function testWithoutFeature() {
		try {
			throw new \PHP\Lang\NotImplementedException();
			$this->fail('Exception not thrown!');
		} catch (\PHP\Lang\NotImplementedException $e) {
			$this->assertNotEquals(false, \strpos($e->getMessage(), (string)__CLASS__ . '::' . __FUNCTION__),
					'Class and function name of thrower is not in message! Message was: ' . $e->getMessage());
		}
	}
}
