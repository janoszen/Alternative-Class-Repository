<?php

namespace PHP\IO;

\ClassLoader::import('PHP\Lang\Object');

class InputStream extends \PHP\Lang\Object {
	/**
	 * Returns the number of bytes available for reading.
	 * 
	 * The available() method for class InputStream always returns 0.
	 * 
	 * This method should be overridden by subclasses.
	 * 
	 * @throws \PHP\IO\IOException if an I/O error occurs.
	 * @return int
	 */
	public function available() {
		return 0;
	}

	/**
	 * Closes this input stream associated with the stream.
	 * 
	 * @throws \PHP\IO\IOException if an I/O error occurs.
	 */
	public function close() {
		
	}

	public function mark($readlimit) {
		
	}
}
