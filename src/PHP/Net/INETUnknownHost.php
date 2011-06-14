<?php

namespace PHP\Net;

\ClassLoader::import('\PHP\Lang\*');
\ClassLoader::import('\PHP\Net\*');

/**
 * This exception indicates, that an address has hit an unknown host error. Basically this means, that the address
 * in question doesn't exist.
 */
class INETUnknownHost extends \PHP\Lang\Exception implements INETException {
	/**
	 * The address in question
	 * @var string
	 */
	protected $address;

	/**
	 * Sets the address that has caused this error.
	 * @param string $address
	 */
	public function __construct($address) {
		parent::__construct('Unknown address: ' . $address);
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
