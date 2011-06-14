<?php

namespace PHP\Net;

\ClassLoader::import('\PHP\Lang\Comparable');
\ClassLoader::import('\PHP\Net\*');

/**
 * This class is an abstract for the IPv4 and IPv6 address classes created as INET4Address and INET6Address. For more
 * information about IP addresses see http://en.wikipedia.org/wiki/IP_address .
 */
abstract class INETAddress implements \PHP\Lang\Comparable {
	/**
	 * Initialize the INETAddress instance with an address from a string.
	 * @param string $address
	 */
	public function __construct($address = '') {
		$this->setAddress($address);
	}
	
	/**
	 * Checks, if the address is a unicast or a broadcast address. (Latter is only valid for IPv4, IPv6 doesn't know
	 * broadcast, only multicast.)
	 * @return bool
	 */
	abstract function isUnicast();

	/**
	 * Checks, if the address is a multicast address.
	 * @return bool
	 */
	abstract public function isMulticast();

	/**
	 * Checks, if the address is a loopback address
	 * @return bool
	 */
	abstract public function isLoopback();

	/**
	 * Checks, if the address is globally routable.
	 * @return bool
	 */
	abstract public function isGloballyRoutable();

	/**
	 * Checks, if this address is within the given INETRange
	 * @param INETRange $range
	 * @throws INETAddressTypeError if the supplied range is not of the same type.
	 * @return bool
	 */
	public function isInRange(INETRange $range) {
		return $range->containsAddress($this);
	}

	/**
	 * Check, if the address is contained in any of the ranges.
	 * If an array member of $ranges is not an instance of INETRange, it is silently discarded.
	 * @param array if INETRange $ranges
	 * @return boolean
	 */
	public function isInRanges($ranges) {
		$contained = false;
		foreach ($ranges as &$range) {
			if ($range instanceof INETRange) {
				if ($this->isInRange($range)) {
					$contained = true;
					break;
				}
			} else {
				// This is not an IPv6 address range, there's nothing to do with it.
			}
		}
		return $contained;
	}

	/**
	 * Set the raw address.
	 * @param string $address
	 * @throws INETAddressFormatError
	 * @return INETAddress
	 */
	abstract public function setAddress($address);
	
	/**
	 * Get normalized string representation of address.
	 * @return string
	 */
	abstract public function getAddress();

	/**
	 * Get binary representation of the address
	 * @param int $mask
	 * @return string
	 */
	abstract public function getAsBinary($mask = null);

	/**
	 * Get address as string
	 * @return string
	 */
	public function __toString() {
		return $this->getAddress();
	}

	/**
	 * Checks, if two INETAddress instances contain the same IP address.
	 * @param INETAddress $address
	 * @return bool
	 */
	public function equals(INETAddress $address) {
		if (get_class($address) != get_class($this)) {
			return false;
		}
		if ($address->getAddress() == $this->getAddress()) {
			return true;
		}
		return false;
	}

	/**
	 * Compare address to an other INETAddress. If $address is smaller in binary terms, it returns -1. If it is equal,
	 * it returns 0. If it is larger, it returns 1.
	 * @param INETAddress $address
	 * @throws INETAddressTypeError if the two addresses are not of the same type.
	 * @return int
	 */
	public function compareTo(self $address) {
		if (\get_class($address) != \get_class($this)) {
			throw new INETAddressTypeError($address, get_class($this));
		}
		return \strcmp($address->getAsBinary(), $this->getAsBinary());
	}
}
