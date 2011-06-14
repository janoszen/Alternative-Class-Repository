<?php

namespace PHP\Net;

\ClassLoader::import('\PHP\Net\*');

/**
 * This class tests the functionality of INETAddressFormatError.
 */
class INETAddressFormatErrorTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests, that INETAddressFormatError is actually an INETException and passes the address parameter correctly.
	 */
	public function testAddress() {
		try {
			throw new INETAddressFormatError('1.2.3.4');
		} catch (INETException $e) {
			if (!$e instanceof INETAddressFormatError) {
				$this->fail('Throwing INETAddressFormatError resulted in an other INET exception!');
			} else {
				$this->assertEquals('1.2.3.4', $e->getAddress(), 'INETAddressFormatError does not correctly pass the address!');
			}
		} catch (Exception $e) {
			$this->fail('INETAddressFormatError does not extend INETException!');
		}
	}
}
