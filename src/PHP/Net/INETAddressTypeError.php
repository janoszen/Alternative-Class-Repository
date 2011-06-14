<?php

namespace PHP\Net;

\ClassLoader::import('\PHP\Lang\*');
\ClassLoader::import('\PHP\Net\*');

/**
 * This exception indicates, that an INETAddress is not of the required type.
 */
class INETAddressTypeError extends \PHP\Lang\TypeError implements INETException {
	/**
	 * Sets the address that has caused this error.
	 * @param INETAddress $address
	 */
	public function __construct(INETAddress $address, $required) {
		parent::__construct($address, $required);
	}
}
