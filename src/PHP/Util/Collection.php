<?php

namespace PHP\Util;

\ClassLoader::import("\PHP\Lang\*");
\ClassLoader::import("\PHP\Util\ArrayObject");

/**
 * This is a generic Collection (array) class, which can be used as an object
 * container and overridden by child classes. Can be accessed as a native PHP
 * array.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class Collection extends ArrayObject {
	/**
	 * Throws a \PHP\Lang\ValueError, if $offset is not an integer
	 *
	 * @param int $offset
	 *
	 * @throws \PHP\Lang\ValueError if $offset is not an integer.
	 */
	final protected function keyCheck($offset) {
		if (!\is_int($offset)) {
			throw new \PHP\Lang\ValueError($offset, "integer");
		}
	}
}
