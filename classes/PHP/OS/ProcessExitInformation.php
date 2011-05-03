<?php

namespace PHP\OS;

/**
 * This class contains all relevant information, that can be collected, if a
 * process exits.
 */
class ProcessExitInformation {
	protected $pid = 0;
	protected $exited = false;
	protected $stopped = false;
	protected $signaled = false;
	protected $signal = false;

	public function setPid($pid) {
		$this->pid = (int)$pid;
		return $this;
	}

	public function getPid() {
		return $this->pid;
	}

	public function setExited($exited) {
		$this->exited = (bool)$exited;
		return $this;
	}

	public function hasExited() {
		return $this->exited;
	}

	public function setStopped($stopped) {
		$this->stopped = (bool)$stopped;
		return $this;
	}

	public function hasStoppedBySignal() {
		return $this->stopped;
	}

	public function setTerminatedBySignal($signaled) {
		$this->signaled = (bool)$signaled;
		return $this;
	}

	public function hasTerminatedBySignal() {
		return $this->signaled;
	}

	public function setSignal($signal) {
		$this->signal = $signal;
		return $this;
	}

	public function getSignal() {
		return $this->signal;
	}
}
