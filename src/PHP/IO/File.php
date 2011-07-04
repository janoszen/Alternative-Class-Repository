<?php

namespace PHP\IO;

\ClassLoader::import('PHP\IO\*');

/**
 * This class represents a file and contains the utilities for file
 * manipulation.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class File {
	/**
	 * Directory separator on platform
	 *
	 * @var string
	 */
	static protected $separator;

	/**
	 * Full path of file or directory
	 *
	 * @var string
	 */
	protected $pathname;

	/**
	 * Delete file on exit.
	 *
	 * @var bool default false
	 */
	protected $deleteOnExit = false;
	
	/**
	 * Path name for this file
	 *
	 * @param string $path 
	 */
	public function __construct($path) {
		$this->pathname = $path;
	}

	/**
	 * Get the OS-dependant path separator.
	 *
	 * @return string
	 */
	public static function getPathSeparator() {
		if (!self::$separator) {
			self::$separator = \DIRECTORY_SEPARATOR;
		}
		return self::$separator;
	}

	/**
	 * Create a new file with the given name.
	 *
	 * @return File
	 */
	public function createNewFile() {
		if (!\file_exists($this->pathname)) {
			$path = new File($this->getAbsolutePath());
			/**
			 * @todo For some reason this doesn't work. Write more tests or PoC for PHP bug if any.
			if (!$path->canWrite()) {
				throw new \PHP\IO\IOException("Access denied, file creation of " . $this->getPath() . " in "
						. $path->getAbsolutePath() . " failed");
			} else */
			if (!\touch($this->pathname)) {
				throw new \PHP\IO\IOException("File creation of " . $this->pathname . " failed");
			}
		}
		return $this;
	}

	/**
	 * Determine if a file can be read.
	 *
	 * @return bool
	 */
	public function canRead() {
		if (\file_exists($this->pathname) && is_readable($this->pathname)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Determine if a file can be written.
	 *
	 * @return bool
	 */
	public function canWrite() {
		return \is_writable($this->pathname);
	}

	/**
	 * Get the absolute filename for the given path.
	 *
	 * @return string
	 */
	public function getAbsoluteFile() {
		if ($this->isAbsolute()) {
			return \realpath($this->pathname);
		} else {
			return \realpath(\getcwd() . "/" . $this->pathname);
		}
	}

	/**
	 * Get the absolute path for a given file
	 *
	 * @return string
	 */
	public function getAbsolutePath() {
		return \dirname($this->getAbsoluteFile());
	}

	/**
	 * Get a File object with the cannonical name.
	 *
	 * @return File
	 */
	public function getCanonicalFile() {
		return new File($this->getAbsoluteFile());
	}

	/**
	 * Get a File object with the path of a cannonical name.
	 *
	 * @return File
	 */
	public function getCanonicalPath() {
		return new File($this->getAbsolutePath());
	}

	/**
	 * Get the path as a string.
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->pathname;
	}

	/**
	 * Determine if a path name is an absolute path.
	 *
	 * @return bool
	 */
	public function isAbsolute() {
		if ((\substr($this->pathname, 0, 1) != self::getPathSeparator())
				&& (\substr($this->pathname, 1, 1 + \strlen(self::getPathSeparator()))
						!= ":" . self::getPathSeparator())) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Determine, if the path given is a directory.
	 *
	 * @return bool
	 */
	public function isDirectory() {
		return \is_dir($this->pathname);
	}

	/**
	 * Determine, if the path given is a file.
	 *
	 * @return bool
	 */
	public function isFile() {
		return \is_file($this->pathname);
	}

	/**
	 * Create a directory with the current filename.
	 *
	 * @return File
	 */
	public function mkdir() {
		if (!\mkdir($this->pathname)) {
			throw new \PHP\IO\IOException("");
		}
		return $this;
	}

	/**
	 * Rename file to new name
	 *
	 * @param File $dest
	 * @return File
	 */
	public function renameTo(File $dest) {
		if (!\rename($this->pathname, $dest->getAbsoluteFile())) {
			throw new IOException("renameTo of " . $this->pathname . " to " . $dest->getAbsoluteFile() . " failed.");
		}
		return $this;
	}

	/**
	 * Unlink current file or directory from filesystem
	 */
	public function unlink() {
		\unlink($this->pathname);
	}

	/**
	 * Remove files, which have been marked for delete on exit.
	 */
	public function __destruct() {
		if ($this->deleteOnExit) {
			$this->unlink();
		}
	}
}
