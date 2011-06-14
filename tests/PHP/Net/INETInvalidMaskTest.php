<?php

namespace PHP\Net;

\ClassLoader::import('\PHP\Net\*');

/**
 * This class tests the functionality of INETInvalidMask.
 */
class INETInvalidMaskTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests, that INETAddressFormatError is actually an INETException and passes the address parameter correctly.
	 */
	public function testAddress() {
		try {
			throw new INETInvalidMask(48);
		} catch (INETException $e) {
			if (!$e instanceof INETInvalidMask) {
				$this->fail('Throwing INETInvalidMask resulted in an other INET exception!');
			} else {
				$this->assertEquals(48, $e->getMask(), 'INETInvalidMask does not correctly pass the mask!');
			}
		} catch (Exception $e) {
			$this->fail('INETInvalidMask does not extend INETException!');
		}
	}
}
