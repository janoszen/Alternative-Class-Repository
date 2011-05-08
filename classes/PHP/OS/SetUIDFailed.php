<?php
/**
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 * @package PHP.OS
 */

namespace PHP\OS;

\ClassLoader::import('PHP\OS\Exception');

/**
 * This class indicates, that a setuid has failed.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class SetUIDFailed extends \PHP\OS\Exception {
	function __construct($uid) {
		parent::__construct("Failed to set UID to " . $uid);
	}
}
