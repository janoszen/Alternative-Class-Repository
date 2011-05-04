<?php

namespace PHP\OS;

\ClassLoader::import('PHP\OS\Exception');

/**
 * This class indicates, that a fork has failed.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class ForkFailed extends \PHP\OS\Exception {
	function __construct(\PHP\Lang\ErrorException $e) {
		parent::__construct($e->getMessage(), $e);
	}
}