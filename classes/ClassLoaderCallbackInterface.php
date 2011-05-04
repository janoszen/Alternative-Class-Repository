<?php

/**
 * This interface states, that the ClassLoader should call back
 * the class on load.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
interface ClassLoaderCallbackInterface {
	/**
	 * Callback function on class load
	 */
	static function onClassLoaded();
}
