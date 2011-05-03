<?php

namespace PHP\OS;

\ClassLoader::import('PHP\OS\Exception');

/**
 * This class indicates, that a fork has failed.
 */
class ForkFailed extends \PHP\OS\Exception {
	function __construct(\PHP\Lang\ErrorException $e) {
		parent::__construct($e->getMessage(), $e);
	}
}