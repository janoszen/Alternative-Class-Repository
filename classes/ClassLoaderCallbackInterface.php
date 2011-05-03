<?php

/**
 * This interface states, that the ClassLoader should call back
 * the class on load.
 */
interface ClassLoaderCallbackInterface {
	/**
	 * Callback function on class load
	 */
	static function onClassLoaded();
}
