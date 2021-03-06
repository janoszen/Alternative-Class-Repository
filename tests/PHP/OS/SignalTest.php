<?php

namespace PHP\OS;

\ClassLoader::import('PHP\Lang\*');
\ClassLoader::import('PHP\Util\*');
if (substr(\PHP_OS, 0, 3) != 'Windows') {
	\ClassLoader::import('PHP\OS\Signal');
}

/**
 * Test class for Signal.
 * Generated by PHPUnit on 2011-07-09 at 17:57:14.
 */
class SignalTest extends \PHPUnit_Framework_TestCase {
	function testValidateSignals() {
		if (substr(\PHP_OS, 0, 3) == 'WIN') {
			$this->markTestSkipped('POSIX and PCNTL extensions are not available on Windows.');
		} else {
			try {
				Signal::validateSignals(new \PHP\Util\Collection(array('test')));
				$this->fail('Passing a string as a signal did not result in a TypeError');
			} catch (\PHP\Lang\TypeError $e) { }
			try {
				Signal::validateSignals(new \PHP\Util\Collection(array(-1)));
				$this->fail('-1 is an invalid signal and should not be blockable');
			} catch (\PHP\Lang\ValueError $e) { }
		}
	}
}
