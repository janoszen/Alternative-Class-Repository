<?php

/**
 * This is a test class for the ClassLoaderCallbackInterface
 */
class TestClassWithCallback implements ClassLoaderCallbackInterface {
	protected static $hadCallback = false;
	public static function onClassLoaded() {
		self::$hadCallback = true;
	}
	public static function getHadCallback() {
		return self::$hadCallback;
	}
}
