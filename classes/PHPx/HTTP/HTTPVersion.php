<?php

namespace PHPx\HTTP;

\ClassLoader::import('PHP\Lang\*');

/**
 * This object represents a HTTP version number
 */
class HTTPVersion implements \PHP\Lang\Comparable {
	/**
	 * HTTP version 1.1, which ads:
	 * <ul>
	 *     <li>Cache-Control</li>
	 *     <li>Vary</li>
	 *     <li>Range request</li>
	 *     <li>Modified header handling</li>
	 *     <li>Expect header</li>
	 *     <li>Compression</li>
	 *     <li>Chunked transfer-encoding</li>
	 *     <li>Persistent connections</li>
	 *     <li>Pipelining</li>
	 *     <li>Content negotiation</li>
	 * </ul>
	 */
	const VERSION11 = '1.1';
	/**
	 * HTTP version 1.0, which ads:
	 * <ul>
	 *     <li>Host header</li>
	 *     <li>Caching</li>
	 *     <li>HTTP Basic Authentication</li>
	 * </ul>
	 */
	const VERSION10 = '1.0';
	/**
	 * HTTP version 0.9, which is the first HTTP version.
	 */
	const VERSION09 = '0.9';

	/**
	 * Major version number
	 * @var int
	 */
	protected $major;
	/**
	 * Minor version number
	 * @var int
	 */
	protected $minor;

	/**
	 * Initialize version. Defaults to HTTP 1.1
	 * @param string $version default "1.1"
	 */
	function __construct($version = HTTPVersion::VERSION11) {
		$this->parse($version);
	}

	/**
	 * Parse a version number
	 * @param string $version
	 * @return HTTPVersion
	 * @throws \PHP\Lang\TypeError if the version number given is not a string
	 * @throws \PHP\Lang\ValueError if the version number given is not in the
	 *  major.minor format.
	 */
	public function parse($version) {
		if (!\is_string($version)) {
			throw new \PHP\Lang\TypeError($version, 'string');
		}
		if (!\preg_match('/^(?P<major>[0-9]+)\.(?P<minor>[0-9]+)$/', $version, $matches)) {
			throw new \PHP\Lang\ValueError($version, 'Valid version number');
		}
		$this->setMajor((int)$matches['major']);
		$this->setMinor((int)$matches['minor']);
		return $this;
	}

	/**
	 * Converts the version number to a string
	 * @return string
	 */
	public function __toString() {
		return $this->major . '.' . $this->minor;
	}

	/**
	 * Set the major version number.
	 * @param int $version
	 * @return HTTPVersion
	 * @throws \PHP\Lang\TypeError if the version number is not an integer
	 * @throws \PHP\Lang\ValueError if the version number is negative
	 */
	public function setMajor($version) {
		if (!is_int($version)) {
			throw new \PHP\Lang\TypeError($version, 'integer');
		}
		if ($version<0) {
			throw new \PHP\Lang\ValueError($version, 'positive integer');
		}
		$this->major = $version;
		return $this;
	}

	/**
	 * Return the major version number.
	 * @return int
	 */
	public function getMajor() {
		return $this->major;
	}

	/**
	 * Set the minor version number.
	 * @param int $version
	 * @return HTTPVersion
	 * @throws \PHP\Lang\TypeError if the version number is not an integer
	 * @throws \PHP\Lang\ValueError if the version number is negative
	 */
	public function setMinor($version) {
		if (!is_int($version)) {
			throw new \PHP\Lang\TypeError($version, 'integer');
		}
		if ($version<0) {
			throw new \PHP\Lang\ValueError($version, 'positive integer');
		}
		$this->minor = $version;
		return $this;
	}

	/**
	 * Get the minor version number
	 * @return int
	 */
	public function getMinor() {
		return $this->minor;
	}

	/**
	 * Compare two version numbers
	 * @param HTTPVersion $o
	 * @return int
	 */
	public function compareTo(HTTPVersion $o) {
		if ($o->getMajor() < $this->getMajor()) {
			return -1;
		} else if ($o->getMajor() > $this->getMajor()) {
			return 1;
		} else if ($o->getMinor() < $this->getMinor()) {
			return -1;
		} else if ($o->getMinor() > $this->getMinor()) {
			return 1;
		} else {
			return 0;
		}
	}
}
