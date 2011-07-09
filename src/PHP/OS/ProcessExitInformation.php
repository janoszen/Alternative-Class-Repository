<?php

namespace PHP\OS;

/**
 * This class contains all relevant information, that can be collected, if a
 * process exits.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class ProcessExitInformation {
	/**
	 * The PID of the child, that exited.
	 * @var int
	 */
	protected $pid = 0;
	/**
	 * If the child has exited
	 * @var bool
	 */
	protected $exited = false;
	/**
	 * If the child has been stopped
	 * @var bool
	 */
	protected $stopped = false;
	/**
	 * If the child has exited by a signal
	 * @var bool
	 */
	protected $signaled = false;
	/**
	 * The signal the child has exited with
	 * @var int
	 */
	protected $signal = false;

	/**
	 * Set the PID of the child
	 * @param int $pid
	 * @return ProcessExitInformation
	 */
	public function setPid($pid) {
		$this->pid = (int)$pid;
		return $this;
	}

	/**
	 * Get the PID of the child.
	 * @return int
	 */
	public function getPid() {
		return $this->pid;
	}

	/**
	 * Set, if the process has exit()-ed.
	 * @param bool $exited
	 * @return ProcessExitInformation
	 */
	public function setExited($exited) {
		$this->exited = (bool)$exited;
		return $this;
	}

	/**
	 * Returns, if the process has exit()-ed
	 * @return bool
	 */
	public function hasExited() {
		return $this->exited;
	}

	/**
	 * Set, if the process has stopped.
	 * @param bool $stopped
	 * @return ProcessExitInformation
	 */
	public function setStopped($stopped) {
		$this->stopped = (bool)$stopped;
		return $this;
	}

	/**
	 * Returns, if the process has been stopped by a signal
	 * @return bool
	 */
	public function hasStoppedBySignal() {
		return $this->stopped;
	}

	/**
	 * Set, if the process has terminated by a signal
	 * @param bool $signaled
	 * @return ProcessExitInformation
	 */
	public function setTerminatedBySignal($signaled) {
		$this->signaled = (bool)$signaled;
		return $this;
	}

	/**
	 * Returns, if the process has terminated by a signal
	 * @return bool
	 */
	public function hasTerminatedBySignal() {
		return $this->signaled;
	}

	/**
	 * Set the signal the process acted upon
	 * @param int $signal
	 * @return ProcessExitInformation
	 */
	public function setSignal($signal) {
		$this->signal = $signal;
		return $this;
	}

	/**
	 * Get the signal the process has acted uppon
	 * @return int
	 */
	public function getSignal() {
		return $this->signal;
	}
}
