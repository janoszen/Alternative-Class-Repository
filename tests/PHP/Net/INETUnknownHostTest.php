<?php

namespace PHP\Net;

\ClassLoader::import('\PHP\Net\*');

/**
 * This class tests the functionality of INETUnknownHost.
 */
class INETUnknownHostTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Tests, that INETUnknownHost is actually an INETException and passes the address parameter correctly.
	 */
	public function testAddress() {
		try {
			throw new INETUnknownHost('1.2.3.4');
		} catch (INETException $e) {
			if (!$e instanceof INETUnknownHost) {
				$this->fail('Throwing INETUnknownHost resulted in an other INET exception!');
			} else {
				$this->assertEquals('1.2.3.4', $e->getAddress(), 'INETUnknownHost does not correctly pass the address!');
			}
		} catch (Exception $e) {
			$this->fail('INETUnknownHost does not extend INETException!');
		}
	}
}
