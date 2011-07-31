<?php

namespace PHP\Lang;

\ClassLoader::import('PHP\Lang\Object');
\ClassLoader::import('PHP\Lang\TypeError');
\ClassLoader::import('PHP\Lang\ValueError');
\ClassLoader::import('PHP\Util\Random');

/**
 * This class contains the standard mathematical functions.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class Math extends Object {

	/**
	 * The number PI
	 */
	const PI = M_PI;

	/**
	 * The number e
	 */
	const E = M_E;

	/**
	 * The Euler-constant
	 */
	const EULER = M_EULER;

	/**
	 * Not-A-Number (float)
	 */
	const NAN = NAN;

	/**
	 * Infinite (float)
	 */
	const INF = INF;

	/**
	 * Returns the distance from 0 for a given number
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function abs($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \abs($number);
	}

	/**
	 * Returns the arc cosine value of a number.
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function acos($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \acos($number);
	}

	/**
	 * Returns the arc sine value of a number.
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function asin($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \asin($number);
	}

	/**
	 * Returns the arc tangent value of a number.
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function atan($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \atan($number);
	}

	/**
	 * Returns the smallest value that is not less than $number and
	 * is equal to an integer.
	 * @param float $number
	 * @return integer
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function ceil($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \ceil($number);
	}

	/**
	 * Returns the largest value that is not more than $number and
	 * is equal to an integer.
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function cos($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \cos($number);
	}

	/**
	 * Returns the exponent of e of a number.
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function exp($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \exp($number);
	}

	/**
	 * Returns the exponent of e of a number.
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function floor($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \floor($number);
	}

	/**
	 * Returns the exponent of e of a number.
	 * @param float $number
	 * @param float $base default Math::E
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number or $base is not a number
	 */
	public static function log($number, $base = Math::E) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		if (!\is_int($base) && !is_float($base)) {
			throw new TypeError($base, "number");
		}
		return \base($number, $base);
	}

	/**
	 * Returns the maximum of two values
	 * @param float $number1
	 * @param float $number2
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number1 or $number2 is not a number
	 */
	public static function max($number1, $number2) {
		if (!\is_int($number1) && !is_float($number1)) {
			throw new TypeError($number1, "number");
		}
		if (!\is_int($number2) && !is_float($number2)) {
			throw new TypeError($number2, "number");
		}
		return \max($number1, $number2);
	}

	/**
	 * Returns the minimum of two values
	 * @param float $number1
	 * @param float $number2
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number1 or $number2 is not a number
	 */
	public static function min($number1, $number2) {
		if (!\is_int($number1) && !is_float($number1)) {
			throw new TypeError($number1, "number");
		}
		if (!\is_int($number2) && !is_float($number2)) {
			throw new TypeError($number2, "number");
		}
		return \min($number1, $number2);
	}

	/**
	 * Returns $base raised to the power of $exp.
	 * @param float $base
	 * @param float $exp
	 * @return float
	 * @throws \PHP\Lang\TypeError if $base or $exp is not a number
	 */
	public static function pow($base, $exp) {
		if (!\is_int($base) && !is_float($base)) {
			throw new TypeError($base, "number");
		}
		if (!\is_int($exp) && !is_float($exp)) {
			throw new TypeError($exp, "number");
		}
		return \pow($base, $exp);
	}

	/**
	 * Returns a random number between 0.0 and 1.0.
	 * This is a shortcut for Random::pseudoNumber()
	 * @return float
	 */
	public static function random() {
		return \PHP\Util\Random::pseudoNumber();
	}

	/**
	 * Returns the closes integer to a given float.
	 * @param float $number
	 * @param int $decimals
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function round($number, $decimals = 0) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		if (!\is_int($decimals) && !is_float($decimals)) {
			throw new TypeError($decimals, "number");
		}
		if ($decimals < 0) {
			throw new ValueError($decimals, "positive or 0");
		}
		return \round($number, $decimals);
	}

	/**
	 * Returns the sine value of a number.
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function sin($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \sin($number);
	}

	/**
	 * Returns the square root of a number.
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 * @throws \PHP\Lang\ValueError if $number is negative
	 */
	public static function sqrt($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		if ($number < 0) {
			throw new ValueError($number, 'positive or 0');
		}
		return \sqrt($number);
	}

	/**
	 * Returns the tangent value of a number.
	 * @param float $number
	 * @return float
	 * @throws \PHP\Lang\TypeError if $number is not a number
	 */
	public static function tan($number) {
		if (!\is_int($number) && !is_float($number)) {
			throw new TypeError($number, "number");
		}
		return \tan($number);
	}
}
