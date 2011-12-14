<?php

namespace PHP\Util;

/**
 * Test class for Random.
 * @covers \PHP\Util\Random
 */
class RandomTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests using the \mt_rand() function
	 */
	public function testPseudoNumberMT() {
		if (!\function_exists('\mt_rand')) {
			$this->skipTest('\mt_rand() is not available');
		}
		$number = Random::pseudoNumber(0, 1, Random::NUMBER_METHOD_MTRAND);
		$this->assertEquals('double', \gettype($number));
		$this->assertGreaterThanOrEqual(0, $number);
		$this->assertLessThanOrEqual(1, $number);		
	}

	/**
	 * Tests using the \rand() function
	 */
	public function testPseudoNumber() {
		$number = Random::pseudoNumber(0, 1, Random::NUMBER_METHOD_RAND);
		$this->assertEquals('double', \gettype($number));
		$this->assertGreaterThanOrEqual(0, $number);
		$this->assertLessThanOrEqual(1, $number);		
	}
	
	/**
	 * Tests, that the typechecks are working correctly.
	 */
	public function testPseudoNumberTypeCheck() {
		try {
			Random::pseudoNumber('a');
			$this->fail('TypeCheck error');
		} catch (\PHP\Lang\TypeError $e) { }
		try {
			Random::pseudoNumber(0, 'a');
			$this->fail('TypeCheck error');
		} catch (\PHP\Lang\TypeError $e) { }
		try {
			Random::pseudoNumber(0, 1, -1);
			$this->fail('Value check error');
		} catch (\PHP\Lang\ValueError $e) { }
	}

	/**
	 * Tests using the \openssl_random_pseudo_bytes() function
	 */
	public function testPseudoStringOpenSSL() {
		if (!\function_exists('\openssl_random_pseudo_bytes')) {
			$this->skipTest('\openssl_random_pseudo_bytes() is not available');
		}
		$string = Random::pseudoString(61, Random::STRING_METHOD_OPENSSL);
		$this->assertEquals(61, \strlen($string));
	}
	
	/**
	 * Tests using the \uniqid() function
	 */
	public function testPseudoStringUniqid() {
		$string = Random::pseudoString(61, Random::STRING_METHOD_UNIQID);
		$this->assertEquals(61, \strlen($string));
	}
	
	/**
	 * Tests using the \md5(time()) functions
	 */
	public function testPseudoStringTime() {
		$string = Random::pseudoString(61, Random::STRING_METHOD_TIME);
		$this->assertEquals(61, \strlen($string));
	}
	
	/**
	 * Tests, that the typechecks are working correctly.
	 */
	public function testPseudoStringTypeCheck() {
		try {
			Random::pseudoString('a');
			$this->fail('Type check error');
		} catch (\PHP\Lang\TypeError $e) { }
		try {
			Random::pseudoString(-1);
			$this->fail('Value check error');
		} catch (\PHP\Lang\ValueError $e) { }
		try {
			Random::pseudoString(1, -1);
			$this->fail('Value check error');
		} catch (\PHP\Lang\ValueError $e) { }
	}
}
