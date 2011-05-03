<?php

namespace PHP\OS;

/**
 * Describes a class as a potential receiver for events related to process
 * forks.
 */
interface ForkListener {
	/**
	 * Function to be called immediately before fork. Please note, that this
	 * event is called regardless, if the fork is successful.
	 */
	public function beforeFork();

	/**
	 * Function to be called, if the fork failed for whatever reason. Mainly
	 * useful for cleanup functions.
	 */
	public function onForkFailed();

	/**
	 * Function to be called after a successful fork.
	 *
	 * @param bool $child if the current process is the child or the parent.
	 */
	public function afterFork($child);
}
