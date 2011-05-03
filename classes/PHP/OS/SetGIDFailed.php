<?php

namespace PHP\OS;

\ClassLoader::import('PHP\OS\Exception');

/**
 * This class indicates, that a setgid has failed.
 */
class SetGIDFailed extends \PHP\OS\Exception {
	function __construct($gid) {
		parent::__construct("Failed to set GID to " . $gid);
	}
}
