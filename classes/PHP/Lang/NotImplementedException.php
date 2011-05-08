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
 * Indicates, that some sort of function was not implemented or no driver
 * responsible for it could be found.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class NotImplementedException extends Exception {
	function __construct($feature = "") {
		$feature = (string)$feature;
		if ($feature) {
			parent::__construct("This feature was not implemented: " . $feature);
		} else {
			parent::__construct();
			$trace = $this->getTrace();
			$this->message = 'This feature was not implemented: ' .
					$trace[0]['class'] . '::' . $trace[0]['func'];
		}
	}
}
