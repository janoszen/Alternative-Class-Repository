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
	const NUMBER_METHOD_AUTO=0;
	const NUMBER_METHOD_RAND=1;
	const NUMBER_METHOD_MTRAND=2;
	const STRING_METHOD_AUTO=0;
	const STRING_METHOD_TIME=1;
	const STRING_METHOD_UNIQID=2;
	const STRING_METHOD_OPENSSL=3;
	
	/**
	 * Generate a pseudo-random number between $min and $max. If possible,
	 * this function will use mt_rand() for random number generation. Otherwise
	 * it will fall back to rand(), which uses the libc random number generator.
	 * @param  double $min
	 * @param  double $max
	 * @param  int    $method default \PHP\Util\Random::NUMBER_METHOD_AUTO
	 *                        Random generator method to use. If not available,
	 *                        fallback to auto.
	 * @return double
	 */
	static function pseudoNumber($min = 0, $max = 1,
		$method = self::NUMBER_METHOD_AUTO) {
		if (!\is_numeric($min)) {
			throw new \PHP\Lang\TypeError($min, 'number');
		}
		if (!\is_numeric($max)) {
			throw new \PHP\Lang\TypeError($max, 'number');
		}
		switch ($method) {
			case self::NUMBER_METHOD_AUTO:
			case self::NUMBER_METHOD_MTRAND:
				if (\function_exists('\mt_rand')) {
					$value = \mt_rand();
					$maxvalue = \mt_getrandmax();
					break;
				}
			case self::NUMBER_METHOD_RAND:
				$value = \rand();
				$maxvalue = \getrandmax();
				break;
			default:
				throw new \PHP\Lang\ValueError($method, 'One of the NUMBER_METHOD_* constants');
		}
		return (double)($min + $value * (($max - $min) / $maxvalue));
	}

	/**
	 * Generate a pseudo-random string in the given length. This string is NOT
	 * suitable for cryptographic purposes! Use the \PHPx\Crypto library for
	 * that!
	 * @param  integer $length      default 23
	 * @param  integer $method      default \PHP\Util\Random::STRING_METHOD_AUTO
	 *                              The method to use for random string
	 *                              generation. Falls back to default if the
	 *                              method is not available.
	 * @return string
	 * @throws \PHP\Lang\TypeError  if length is not an integer
	 * @throws \PHP\Lang\ValueError if length is smaller than 1
	 */
	static function pseudoString($length = 23, $method = self::STRING_METHOD_AUTO) {
		if (!\is_integer($length)) {
			throw new \PHP\Lang\TypeError($length, 'integer');
		}
		if ($length < 0) {
			throw new \PHP\Lang\ValueError($length, 'number larger than 0');
		}
		$string = '';
		switch ($method) {
			case self::STRING_METHOD_AUTO:
			case self::STRING_METHOD_OPENSSL:
				if (\function_exists('\openssl_random_pseudo_bytes')) {
					$string = \openssl_random_pseudo_bytes($length, $strong);
					break;
				}
			case self::STRING_METHOD_UNIQID:
				while (\strlen($string) < $length) {
					$string .= \uniqid('', true);
				}
				$string = \substr($string, 0, $length);
				break;
			case self::STRING_METHOD_TIME:
				while (\strlen($string) < $length) {
					$string .= \md5(\time());
				}
				$string = \substr($string, 0, $length);
				break;
			default:
				throw new \PHP\Lang\ValueError($method, 'One of the STRING_METHOD_* constants');
		}
		return $string;
	}
}
