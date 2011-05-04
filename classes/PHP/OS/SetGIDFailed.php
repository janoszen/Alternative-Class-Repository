<?php

namespace PHP\OS;

\ClassLoader::import('PHP\OS\Exception');

/**
 * This class indicates, that a setgid has failed.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class SetGIDFailed extends \PHP\OS\Exception {
	function __construct($gid) {
		parent::__construct("Failed to set GID to " . $gid);
	}
}
