<?php

namespace PHP\Lang;

\ClassLoader::import("\PHP\Lang\Exception");

/**
 * This Exception states, that an invalid type was provided.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class TypeError extends Exception {
	/**
	 *
	 * @param mixed $object the object which does not match the required type
	 * @param string $required the type required
	 */
	function __construct($object, $required = "") {
		$type = 'unknown';
		switch (gettype($object)) {
			case 'object':
				$type = get_class($object);
				break;
			default:
				$type = gettype($object);
				break;
		}
		$message = 'Invalid object type: ' . $type;
		if ($required) {
			$message .= ' expected ' . $required;
		}
		parent::__construct($message);
	}
}
