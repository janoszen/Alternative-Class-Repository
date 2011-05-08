<?php
/**
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 * @package PHP.OS
 */

/**
 * Start of static constructor code.
 */
declare(ticks=1);
/**
 * End of static constructor code.
 */

namespace PHP\OS;

/**
 * This class contains constants and functions related to signal handling.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
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

	/**
	 * Validates a set of signals for type and blockability
	 * @param \PHP\Util\Collection $signals
	 * @throws \PHP\Lang\TypeError if one of the signals is not an integer
	 * @throws \PHP\Lang\ValueError if one of the signals is not blockable
	 * @return \PHP\OS\Signal
	 */
	protected static function validateSignals(\PHP\Util\Collection $signals) {
		foreach ($signals as $signal) {
			if (!is_int($signal)) {
				throw new \PHP\Lang\TypeError($signal, "integer");
			}
			if (!self::isBlockable($signal)) {
				throw new \PHP\Lang\ValueError($signal, "blockable signal identifier");
			}
		}
		return $this;
	}

	/**
	 * Checks, if a given signal is blockable
	 * @param int $signal
	 * @throws \PHP\Lang\TypeError if the given variable is not an integer
	 * @return bool
	 */
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

	/**
	 * Blocks a specific set of signals
	 * @param \PHP\Util\Collection $signals
	 * @return \PHP\OS\Signal
	 */
	public static function block(\PHP\Util\Collection $signals) {
		self::validateSignals($signals);
		\pcntl_sigprocmask(\SIG_BLOCK, $signals->getArrayCopy(), $oldset);
		return $this;
	}

	/**
	 * Unblocks a specific set of signals
	 * @param \PHP\Util\Collection $signals
	 * @return \PHP\OS\Signal
	 */
	public static function unblock(\PHP\Util\Collection $signals) {
		self::validateSignals($signals);
		\pcntl_sigprocmask(\SIG_UNBLOCK, $signals->getArrayCopy(), $oldset);
		return $this;
	}

	/**
	 * Replace the block mask with the given set of signals
	 * @param \PHP\Util\Collection $signals
	 * @return \PHP\OS\Signal
	 */
	public static function replaceBlockMask(\PHP\Util\Collection $signals) {
		self::validateSignals($signals);
		\pcntl_sigprocmask(\SIG_SETMASK, $signals->getArrayCopy(), $oldset);
		return $this;
	}

	/**
	 * Wait for a given signal or signals.
	 * @param \PHP\Util\Collection $signals
	 * @param int $seconds default 0 seconds to wait
	 * @param int $nanoseconds default 0 nanoseconds to wait
	 * @return int
	 */
	public static function wait(\PHP\Util\Collection$signals, $seconds = 0,
			$nanoseconds = 0) {
		self::validateSignals($signals);
		if ($seconds || $nanoseconds) {
			return \pcntl_sigtimedwait($signals->getArrayCopy(), $siginfo,
					$seconds, $nanoseconds);
		} else {
			return \pcntl_sigwaitinfo($signals->getArrayCopy());
		}
	}
}
