<?php

namespace PHP\OS;

\ClassLoader::import('\PHP\IO\*');

/**
 * Describes a class as a potential receiver for events related to process
 * forks.
 */
interface ChrootListener {
	/**
	 * Function to be called immediately before chroot. Please note, that this
	 * event is called regardless, if the chroot is successful.
	 *
	 * @param \PHP\IO\File $directory
	 */
	public function beforeChroot(\PHP\IO\File $directory);

	/**
	 * Function to be called, if the chroot failed for whatever reason. Mainly
	 * useful for cleanup functions.
	 *
	 * @param \PHP\IO\File $directory
	 */
	public function onChrootFailed(\PHP\IO\File $directory);

	/**
	 * Function to be called after a successful chroot.
	 *
	 * @param \PHP\IO\File $directory
	 */
	public function afterChroot(\PHP\IO\File $directory);
}
