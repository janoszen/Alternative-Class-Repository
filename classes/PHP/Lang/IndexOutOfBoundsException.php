<?php
/**
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 * @package PHP.Lang
 */

namespace PHP\Lang;

\ClassLoader::import("\PHP\Lang\Exception");

/**
 * Indicates, that some sort of index (array, string) was out of bounds.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class IndexOutOfBoundsException extends Exception {
	/**
	 * Exception constructor
	 *
	 * @param integer|false $offset the offset in question
	 */
	function __construct($offset = false) {
		if ($offset !== false) {
			parent::__construct("Index out of bounds: " . $offset);
		} else {
			parent::__construct("Index out of bounds");
		}
	}
}
