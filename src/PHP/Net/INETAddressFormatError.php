<?php

namespace PHP\Net;

\ClassLoader::import('\PHP\Lang\*');
\ClassLoader::import('\PHP\Net\*');

/**
 * This exception indicates, that an address is of invalid format.
 */
class INETAddressFormatError extends \PHP\Lang\ValueError implements INETException {
	/**
	 * The address in question.
	 * @var string
	 */
	protected $address;

	/**
	 * Sets the address that has caused this error.
	 * @param string $address
	 */
	public function __construct($address) {
		parent::__construct($address, 'valid address');
		$this->address = $address;
	}

	/**
	 * Get the address, that has caused this exception.
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}
}
