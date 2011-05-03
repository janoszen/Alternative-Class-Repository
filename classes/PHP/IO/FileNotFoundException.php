<?php

namespace PHP\IO;

\ClassLoader::import('PHP\IO\IOException');

/**
 * Indicates, that a given file was not found.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class FileNotFoundException extends IOException {
	function __construct(File $file) {
		parent::__construct("File " . $file . " was not found.");
	}
}
