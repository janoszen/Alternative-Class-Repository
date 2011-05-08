<?php

namespace PHP\Lang;

/**
 * This is the standard system exception extended from the PHP native one.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class Exception extends \Exception {
	/**
	 * Exception constructor
	 *
	 * @param string $message default ""
	 * @param Exception $cause default null the original exception that caused
	 *	this one. Used for exception chaining.
	 */
	function __construct($message = "", Exception $cause = null) {
		parent::__construct($message, 0, $cause);
	}
}
