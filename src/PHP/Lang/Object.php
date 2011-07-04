<?php

namespace PHP\Lang;

\ClassLoader::import('\PHP\Lang\TypeError');
\ClassLoader::import('\PHP\Lang\Math');

/**
 * Generic ancestor class for all in-system classes except Exceptions.
 * @author Janos Pasztor <pasztor.janos@dotroll.com>
 * @copyright DotRoll Ltd (C) All Rights Reserved
 */
abstract class Object {
	/**
	 * A code, which is unique for this instance.
	 * @var string
	 */
	private $hashCode;

	/**
	 * Generates a hashcode
	 */
	public function __construct() {
		$this->generateHashCode();
	}

	/**
	 * Clone helper function to generate a new hashCode. All subclasses must
	 * call parent::__clone.
	 */
	public function __clone() {
		$this->generateHashCode();
	}

	/**
	 * Generates a globally unique hash code. Implementation details are hidden, so subclasses can't depend
	 * on it.
	 * 
	 * Please note, that spl_object_hash is not used, because it reuses the hash code for other objects. Since
	 * we use this code for object comparison, this may result in nasty bugs.
	 */
	private final function generateHashCode() {
		$this->hashCode = \uniqid('', true);
	}

	/**
	 * Check, if two objects are equal in the sense of values. Defaults to hashcode check.
	 * @param Object $obj
	 * @return bool
	 */
	public function equals(Object $obj) {
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
