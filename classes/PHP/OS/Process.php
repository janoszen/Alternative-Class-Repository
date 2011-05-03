<?php

namespace PHP\OS;

\ClassLoader::import('PHP\OS\*');
\ClassLoader::import('PHP\Util\Collection');

class Process {
	/**
	 * A Collection of listeners for fork events.
	 * @var \PHP\Util\Collection
	 */
	protected static $forklisteners;

	/**
	 * A Collection of listeners for chroot events.
	 * @var \PHP\Util\Collection
	 */
	protected static $chrootlisteners;

	/**
	 * Set a class as a listener for fork events. This can be used to
	 * facilitate reconnect needs of specific classes.
	 * 
	 * @param ForkListener $listener
	 */
	public static function setForkListener(ForkListener $listener) {
		if (!self::$forklisteners) {
			self::$forklisteners = new \PHP\Util\Collection();
		}
		if (!self::$forklisteners->contains($listener)) {
			self::$forklisteners->add($listener);
		}
	}

	/**
	 * Remove a ForkListener from the listener collection.
	 * @param ForkListener $listener
	 */
	public static function removeForkListener(ForkListener $listener) {
		if (self::$forklisteners) {
			self::$forklisteners->remove($listener);
		}
	}

	/**
	 * Set a class as a listener for chroot events.
	 *
	 * @param ChrootListener $listener
	 */
	public static function setChrootListener(ChrootListener $listener) {
		if (!self::$chrootlisteners) {
			self::$chrootlisteners = new \PHP\Util\Collection();
		}
		if (!self::$chrootlisteners->contains($listener)) {
			self::$chrootlisteners->add($listener);
		}
	}

	/**
	 * Remove a ChrootListener from the listener collection.
	 * @param ChrootListener $listener
	 */
	public static function removeChrootListener(ChrootListener $listener) {
		if (self::$chrootlisteners) {
			self::$chrootlisteners->remove($listener);
		}
	}

	/**
	 * Forks a child process of the current process, copying everything
	 * including open files and connections. Please be VERY aware, that
	 * you will be using the SAME connection in two processes if you have it
	 * open at the time of forking.
	 *
	 * This function will call all registered \PHP\OS\ForkListener classes
	 * in the event of a fork to ensure connection and data consistency.
	 *
	 * @returns int 0 if in the child process, the pid of the child otherwise.
	 * @throws \PHP\OS\ForkFailed if the fork failed.
	 */
	public static function fork() {
		try {
			if (self::$forklisteners) {
				foreach (self::$forklisteners as $listener) {
					$listener->afterFork();
				}
			}
			
			$pid = \pcntl_fork();
			if ($pid == -1) {
				if (self::$forklisteners) {
					foreach (self::$forklisteners as $listener) {
						$listener->onForkFailed();
					}
				}
				throw new ForkFailed();
			}

			$child = !(bool)$pid;
			if (self::$forklisteners) {
				foreach (self::$forklisteners as $listener) {
					$listener->afterFork($child);
				}
			}
			return $pid;
		} catch (\PHP\Lang\ErrorException $e) {
			if (self::$forklisteners) {
				foreach (self::$forklisteners as $listener) {
					$listener->onForkFailed();
				}
			}
			throw new ForkFailed($e);
		}
	}

	/**
	 * Waits for one child. If requested, it can wait in non-blocking mode,
	 * that is reap the child, if it's available, otherwise return immediately.
	 * If $pid is false, it waits for any child instead of a specific one.
	 *
	 * @param int $pid default false
	 * @param bool $blocking default true wait in blocking mode
	 * @return \PHP\OS\ProcessExitInformation
	 */
	public static function waitForChild($pid = false, $blocking = true) {
		$status = false;
		$options = WUNTRACED;
		if (!$blocking) {
			$options += WNOHANG;
		}
		if ($pid) {
			$newpid = \pcntl_waitpid($pid, $status, $options);
		} else {
			$newpid = \pcntl_wait($status, $options);
		}
		$result = new ProcessExitInformation();
		if ($newpid > 0) {
			$result->setPid($newpid)
				->setExited(\pcntl_wifexited($status))
				->setTerminatedBySignal(\pcntl_wifsignaled($status))
				->setStopped(\pcntl_wifstopped($status));
			if (\pcntl_wifsignaled($status)) {
				$result->setSignal(\pcntl_wtermsig($status));
			}
			if (\pcntl_wifstopped($status)) {
				$result->setSignal(\pcntl_wstopsig($status));
			}
		}
		return $result;
	}

	/**
	 * Handles all pending child reaps. Useful if called from a SIGCLD signal
	 * handler.
	 *
	 * @param bool $blocking default false
	 *
	 * @return \PHP\Util\Collection of \PHP\OS\ProcessExitInformation
	 */
	public static function handleChildTerminations($blocking = false) {
		$children = new \PHP\Util\Collection();
		$exit = false;
		do {
			$status = self::waitForChild(false, $blocking);
			if ($status->getPid()) {
				$children[] = $status;
			} else {
				$exit = true;
			}
		} while(!$exit);
		return $children;
	}

	/**
	 * Set the root filesystem to a new directory. All files not within this
	 * directory will be inaccessible. This can only be done as root on a Unix
	 * system!
	 *
	 * This function also facilitates a callback feature, which can be used
	 * to close outstanding file descriptors. Please note, that in the event
	 * of a chroot failure, the chroot may or may not actually have happened,
	 * so you will have to determine, if the process can be restored to a
	 * working state.
	 *
	 * @param \PHP\IO\File $directory
	 */
	public static function chroot(\PHP\IO\File $directory) {
		if (!$directory->isDirectory()) {
			throw new \PHP\Lang\ValueError($directory, 'existing directory');
		}
		if (self::$chrootlisteners) {
			foreach (self::$chrootlisteners as $listener) {
				$listener->beforeChroot($directory);
			}
		}
		$failed = false;
		if (!\chdir($directory->getAbsolutePath())) {
			$failed = true;
		}
		if (!$failed) {
			if (!\chroot($directory->getAbsolutePath())) {
				$failed = true;
			}
		}
		if (!$failed) {
			if (!\chdir('/')) {
				$failed = true;
			}
		}

		if ($failed) {
			if (self::$chrootlisteners) {
				foreach (self::$chrootlisteners as $listener) {
					$listener->onChrootFailed($directory);
				}
			}
			throw new ChrootFailed($directory);
		}
		if (self::$chrootlisteners) {
			foreach (self::$chrootlisteners as $listener) {
				$listener->afterChroot($directory);
			}
		}
	}

	public function setuid($uid) {
		if (!is_int($uid)) {
			throw new \PHP\Lang\TypeError($uid, "integer");
		}
		if ($uid<0) {
			throw new \PHP\Lang\ValueError($uid, "positive integer");
		}
		if (!\posix_setuid($uid)) {
			throw new \PHP\OS\SetUIDFailed($uid);
		}
	}
}
