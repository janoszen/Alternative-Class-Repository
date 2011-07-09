<?php

namespace PHP\OS;

\ClassLoader::import('PHP\OS\Exception');

/**
 * This class indicates, that a chroot has failed.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class ChrootFailed extends \PHP\OS\Exception {
	function __construct($directory) {
		parent::__construct('Chroot to directory ' . $directory . ' failed');
	}
}
