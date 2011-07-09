<?php

namespace PHP\Util;

\ClassLoader::import("\PHP\Lang\*");
\ClassLoader::import("\PHP\Util\ArrayObject");

/**
 * This is a generic Map (key-value) class, which can be used as an object
 * container and overridden by child classes. Can be accessed as a native PHP
 * array.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class Map extends ArrayObject {
	/**
	 * Throws a \PHP\Lang\ValueError, if $offset is not a string
	 *
	 * @param string $offset
	 *
	 * @throws \PHP\Lang\ValueError if $offset is not a string.
	 */
	final protected function keyCheck($offset) {
		if (!\is_string($offset)) {
			throw new \PHP\Lang\ValueError($offset, "string");
		}
	}
}
