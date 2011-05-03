<?php

declare(ticks=1);

namespace PHP\OS;

class Signal {
	const PROCALL = -1;
	const SIGHUP = \SIGHUP;
	const SIGINT = \SIGINT;
	const SIGQUIT = \SIGQUIT;
	const SIGILL = \SIGILL;
	const SIGTRAP = \SIGTRAP;
	const SIGABRT = \SIGABRT;
	const SIGIOT = \SIGIOT;
	const SIGBUS = \SIGBUS;
	const SIGFPE = \SIGFPE;
	const SIGKILL = \SIGKILL;
	const SIGUSR1 = \SIGUSR1;
	const SIGSEGV = \SIGSEGV;
	const SIGUSR2 = \SIGUSR2;
	const SIGPIPE = \SIGPIPE;
	const SIGALRM = \SIGALRM;
	const SIGTERM = \SIGTERM;
	const SIGSTKFLT = \SIGSTKFLT;
	const SIGCLD = \SIGCLD;
	const SIGCHLD = \SIGCHLD;
	const SIGCONT = \SIGCONT;
	const SIGSTOP = \SIGSTOP;
	const SIGTSTP = \SIGTSTP;
	const SIGTTIN = \SIGTTIN;
	const SIGTTOU = \SIGTTOU;
	const SIGURG = \SIGURG;
	const SIGXCPU = \SIGXCPU;
	const SIGXFSZ = \SIGXFSZ;
	const SIGVTALRM = \SIGVTALRM;
	const SIGPROF = \SIGPROF;
	const SIGWINCH = \SIGWINCH;
	const SIGPOLL = \SIGPOLL;
	const SIGIO = \SIGIO;
	const SIGPWR = \SIGPWR;
	const SIGSYS = \SIGSYS;
	const SIGBABY = \SIGBABY;

	public static function send($pid, $signal) {
		\posix_kill($pid, $signal);
	}

	protected static function validateSignals($signals = array()) {
		foreach ($signals as $signal) {
			if (!is_int($signal)) {
				throw new \PHP\Lang\TypeError($signal, "integer");
			}
			if (!self::isBlockable($signal)) {
				throw new \PHP\Lang\ValueError($signal, "blockable signal identifier");
			}
		}
	}

	protected static function isBlockable($signal) {
		if (!is_int($signal)) {
			throw new \PHP\Lang\TypeError($signal, "integer");
		}
		if ($signal != self::SIGKILL && $signal != self::SIGSTOP) {
			return true;
		} else {
			return false;
		}
	}

	public static function block($signals = array()) {
		if (!is_array($signals)) {
			$signals = array($signals);
		}
		self::validateSignals($signals);
		\pcntl_sigprocmask(\SIG_BLOCK, $signals, $oldset);
	}

	public static function unblock($signals = array()) {
		if (!is_array($signals)) {
			$signals = array($signals);
		}
		self::validateSignals($signals);
		\pcntl_sigprocmask(\SIG_UNBLOCK, $signals, $oldset);
	}

	public static function replaceBlockMask($signals = array()) {
		self::validateSignals($signals);
		\pcntl_sigprocmask(\SIG_SETMASK, $signals, $oldset);
	}

	/**
	 * Wait for a given signal or signals.
	 * @param array $signals
	 * @param int $seconds default 0 seconds to wait
	 * @param int $nanoseconds default 0 nanoseconds to wait
	 * @return int
	 */
	public static function wait($signals = array(), $seconds = 0, $nanoseconds = 0) {
		if (!is_array($signals)) {
			$signals = array($signals);
		}
		self::validateSignals($signals);
		if ($seconds || $nanoseconds) {
			return \pcntl_sigtimedwait($signals, $siginfo, $seconds, $nanoseconds);
		} else {
			return \pcntl_sigwaitinfo($signals);
		}
	}
}
