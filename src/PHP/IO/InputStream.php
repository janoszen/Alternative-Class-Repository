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

	/**
	 * Marks a position with read limit in the stream to jump back to, if markSupported() returns true.
	 * @throws \PHP\Lang\NotImplementedException if markSupported() does not return true.
	 * @param int $readlimit 
	 */
	public function mark($readlimit) {
		if (!$this->markSupported()) {
			throw new \PHP\Lang\NotImplementedException('mark');
		}
	}
	
	/**
	 * Returns, if mark is supported with this stream.
	 * @return bool
	 */
	public function markSupported() {
		return false;
	}
	
	/**
	 * Read the maximum of $length bytes from stream into $bytes skipping $skip number of bytes from the current
	 * position.
	 * @param string $bytes by-reference string to put read bytes into.
	 * @param int $skip default 0 bytes to skip from current position
	 * @param int $length maximum number of bytes to read
	 * @return int number of bytes read
	 */
	public function read(&$bytes = null, $skip = 0, $length = 1024) {
		return 0;
	}
	
	/**
	 * Reset the stream position to the position mark() was last called, if markSupported() returns true. If not,
	 * this function does nothing.
	 */
	public function reset() {
		
	}
	
	/**
	 * Skip over and discard $bytes bytes from the stream
	 * @param int $bytes 
	 */
	public function skip($bytes = 0) {
		
	}
}
