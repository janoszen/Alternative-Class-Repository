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
 * Thrown when an application attempts to use null in a case where an object is
 * required.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class NullPointerException extends Exception {
	
}
