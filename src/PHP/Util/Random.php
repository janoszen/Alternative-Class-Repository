<?php

namespace PHP\Util;

\ClassLoader::import('PHP\Lang\Object');
\ClassLoader::import('PHP\Lang\TypeError');
\ClassLoader::import('PHP\Lang\ValueError');

/**
 * Utility for generating random numbers.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class Random extends \PHP\Lang\Object {
	/**
	 * Generate a pseudo-random number between $min and $max. If possible,
	 * this function will use mt_rand() for random number generation. Otherwise
	 * it will fall back to rand(), which uses the libc random number generator.
	 * @param float $min
	 * @param float $max
	 * @return float
	 */
	static function pseudoNumber($min = 0, $max = 1) {
		if (!\is_numeric($min)) {
			throw new \PHP\Lang\TypeError($min, 'number');
		}
		if (!\is_numeric($max)) {
			throw new \PHP\Lang\TypeError($max, 'number');
		}
		if (\function_exists('mt_rand')) {
			$value = \mt_rand();
			$maxvalue = \mt_getrandmax();
		} else {
			$value = \rand();
			$maxvalue = \getrandmax();
		}
		return $min + $value * (($max - $min) / $maxvalue);
	}

	/**
	 * Generate a pseudo-random string in the given length. This string is NOT
	 * suitable for cryptographic purposes! Use the \PHPx\Crypto library for
	 * that!
	 * @param integer $length default 23
	 * @return string
	 * @throws \PHP\Lang\TypeError if length is not an integer
	 * @throws \PHP\Lang\ValueError if length is smaller than 1
	 */
	static function pseudoString($length = 23) {
		if (!\is_integer($length)) {
			throw new \PHP\Lang\TypeError($length, 'integer');
		}
		if ($length<1) {
			throw new \PHP\Lang\ValueError($length, 'number larger than 0');
		}
		$string = '';
		while (\strlen($string) < $length) {
			$string .= \uniqid('', true);
		}
		return \substr($string, 0, $length);
	}
}
