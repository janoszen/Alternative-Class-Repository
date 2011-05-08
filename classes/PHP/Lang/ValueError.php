<?php

namespace PHP\Lang;

\ClassLoader::import("\PHP\Lang\Exception");

/**
 * This Exception states, that an invalid value was provided.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class ValueError extends Exception {
	/**
	 *
	 * @param mixed $object the object which does not match the required type
	 * @param string $required the type required
	 */
	function __construct($value, $required = "") {
		$message = 'Invalid value: ' . $value;
		if ($required) {
			$message .= ' expected ' . $required;
		}
		parent::__construct($message);
	}
}
