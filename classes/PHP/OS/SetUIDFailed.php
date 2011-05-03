<?php

namespace PHP\OS;

\ClassLoader::import('PHP\OS\Exception');

/**
 * This class indicates, that a setuid has failed.
 */
class SetUIDFailed extends \PHP\OS\Exception {
	function __construct($uid) {
		parent::__construct("Failed to set UID to " . $uid);
	}
}
