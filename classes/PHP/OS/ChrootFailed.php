<?php

namespace PHP\OS;

\ClassLoader::import('PHP\OS\Exception');

/**
 * This class indicates, that a chroot has failed.
 */
class ChrootFailed extends \PHP\OS\Exception {
	function __construct($directory) {
		parent::__construct('Chroot to directory ' . $directory . ' failed');
	}
}
