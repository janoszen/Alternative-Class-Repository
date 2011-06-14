<?php

namespace PHP\Net;

\ClassLoader::import('\PHP\Lang\*');
\ClassLoader::import('\PHP\Net\*');

/**
 * This exception indicates, that an invalid INET mask was provided
 */
class INETInvalidMask extends \PHP\Lang\ValueError implements INETException {
	/**
	 * The invalid mask
	 * @var mixed
	 */
	protected $mask;

	/**
	 * Sets the mask, that has caused the error
	 * @param mixed $mask
	 */
	public function __construct($mask) {
		parent::__construct($mask, 'valid INET mask');
		$this->mask = $mask;
	}

	/**
	 * Get the mask, that has caused the problem.
	 * @return mixed
	 */
	public function getMask() {
		return $this->mask;
	}
}
