<?php

namespace PHP\Net;

\ClassLoader::import('\PHP\Net\*');

/**
 * A network range representation for both IPv4 and IPv6 ranges.
 */
class INETRange {
	/**
	 * The INETAddress, that is used as a base for the range.
	 * @var INETAddress
	 */
	protected $address;

	/**
	 * The mask that is used to get the binary form
	 * @var int
	 */
	protected $mask;

	/**
	 * The binary representation for the network base address
	 * @var string
	 */
	protected $binary;

	/**
	 * Creates a new network range representation.
	 * @param INETAddress $address
	 * @param int $mask
	 * @throws INETInvalidMask if the mask is invalid for the base address
	 */
	function __construct(INETAddress $address, $mask) {
		$this->address = $address;
		$this->mask = $mask;
		$this->binary = $this->address->getAsBinary($mask);
	}

	/**
	 * Returns, if the INETAddress provided is within the network range.
	 * @param INETAddress $address
	 * @throws INETAddressTypeError if the range and the address is not compatible.
	 * @return bool
	 */
	function containsAddress(INETAddress $address) {
		if (get_class($address) != get_class($this->address)) {
			throw new INETAddressTypeError($address, get_class($this->address));
		}
		if (strcmp($address->getAsBinary($this->mask), $this->binary) == 0) {
			return true;
		} else {
			return false;
		}
	}
}
