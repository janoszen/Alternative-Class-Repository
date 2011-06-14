<?php

/**
 * This is a test class for the ClassLoaderCallbackInterface
 */
class TestClassWithCallback implements ClassLoaderCallbackInterface {
	/**
	 * Flag variable to store, if the class loader callback has been called.
	 * @var bool default false
	 */
	protected static $hadCallback = false;
	/**
	 * Class loader callback
	 */
	public static function onClassLoaded() {
		self::$hadCallback = true;
	}
	/**
	 * Query function if the class loader callback has been called
	 * @return bool
	 */
	public static function getHadCallback() {
		return self::$hadCallback;
	}
}
