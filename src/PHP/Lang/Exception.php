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
	 * A code, which is unique for this instance.
	 * @var string
	 */
	private $hashCode;

	/**
	 * Exception constructor
	 *
	 * @param string $message default ""
	 * @param Exception $cause default null the original exception that caused
	 * 	this one. Used for exception chaining.
	 */
	function __construct($message = "", Exception $cause = null) {
		parent::__construct($message, 0, $cause);
		$this->generateHashCode();
	}

	/**
	 * Generates a globally unique hash code. Implementation details are hidden, so subclasses can't depend
	 * on it.
	 */
	private final function generateHashCode() {
		$this->hashCode = \uniqid('', true);
	}

	/**
	 * Check, if two objects are equal in the sense of values. Defaults to hashcode check.
	 * @param Exception $obj
	 * @return bool
	 */
	public function equals(Exception $obj) {
		if ($this->hashCode() == $obj->hashCode()) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get the name of this class.
	 * @return string
	 */
	public final function getClass() {
		return \get_class($this);
	}

	/**
	 * Returns a globally unique ID for this class instance. Unline Java, this is a string.
	 * @return string
	 */
	public final function hashCode() {
		return $this->hashCode;
	}

	/**
	 * Alias for Object::toString()
	 * @return string
	 */
	public final function __toString() {
		return $this->toString();
	}

	/**
	 * This function returns the string representation of this class. Defaults to ClassName@hashcode
	 * @return string
	 */
	public function toString() {
		return $this->getClass() . '@' . $this->hashCode();
	}
}
