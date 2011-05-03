<?php

namespace PHP\Lang;

/**
 * Simplifies comparison of objects
 */
interface Comparable {
	/**
	 * Compares an object to an other object of the same type.
	 * @return -1 if smaller, 0 if equal, 1 if larger than current object.
	 */
	public function compareTo(self $o);
}
