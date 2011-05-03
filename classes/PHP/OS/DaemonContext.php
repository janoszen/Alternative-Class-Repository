<?php

namespace PHP\OS;

\ClassLoader::import('PHP\Lang\*');
\ClassLoader::import('PHP\IO\*');
\ClassLoader::import('PHP\OS\*');

class DaemonContext {
	protected $workingDir;
	protected $uid;
	protected $gid;
	protected $chroot;
	protected $stdin;
	protected $stdout;
	protected $stderr;

	const STARTUP_OK = 0;
	const STARTUP_FAILED = 1;
	const STARTUP_INTERRUPTED = 2;

	function __construct() {
		$this->workingDir = new \PHP\IO\File('/');
		$this->uid = \posix_getuid();
		$this->gid = \posix_getgid();
		$this->chroot = new \PHP\IO\File('/');
	}

	function setWorkingDir(\PHP\IO\File $workingDir) {
		if (!$workingDir->isDirectory()) {
			throw new \PHP\Lang\ValueError($workingDir->getPath(), 'existing directory');
		}
		$this->workingDir = $workingDir;
	}

	function getWorkingDir() {
		return $this->workingDir;
	}

	function setUid($uid) {
		if (!\is_int($uid)) {
			throw new \PHP\Lang\TypeError($uid, 'integer');
		}
		if ($uid < 0) {
			throw new \PHP\Lang\ValueError($uid, 'positive integer');
		}
		$this->uid = $uid;
	}

	function getUid() {
		return $this->uid;
	}

	function setGid($gid) {
		if (!\is_int($gid)) {
			throw new \PHP\Lang\TypeError($gid, 'integer');
		}
		if ($gid < 0) {
			throw new \PHP\Lang\ValueError($gid, 'positive integer');
		}
		$this->gid = $gid;
	}

	function getGid() {
		return $this->gid;
	}

	function setChroot(\PHP\IO\File $chroot) {
		if (!$chroot->isDirectory()) {
			throw new \PHP\Lang\ValueError($chroot->getPath(), 'existing directory');
		}
		$this->chroot = $chroot;
	}

	function getChroot() {
		return $this->chroot;
	}

	function outputHandler($output) {
	}

	function runAsDaemon(Daemon $daemon) {
		Signal::block(array(Signal::SIGUSR2, Signal::SIGCLD, Signal::SIGINT,
			Signal::SIGTERM));
		$pid = Process::fork();
		if ($pid == 0) {
			Signal::replaceBlockMask(array());
			$daemon->load();

			if ($this->chroot->getAbsolutePath() != '/') {
				Process::chroot($this->chroot);
			}

			if ($this->workingDir->getAbsolutePath() <> '/') {
				\chdir($this->workingDir->getAbsolutePath());
			}

			\ignore_user_abort(true);
			\ob_implicit_flush(true);
			\ob_start(array($this, 'outputHandler'));

			/**
			 * This section tests, if we have dup2() support and attempts
			 * to load the dup2 module if available. In most cases this will not
			 * work.
			 *
			 * Note: at the time of writing no working dup2() extension is
			 * available. It is planned as a later project.
			 */
			$dup2support = false;
			if (\PHP_OS == 'Linux') {
				$dup2file = __DIR__ . \DIRECTORY_SEPARATOR . 'dup2.so';
			} else if (\PHP_OS == 'Windows') {
				$dup2file = __DIR__ . \DIRECTORY_SEPARATOR . 'dup2.dll';
			}
			if (\is_callable('dup2')) {
				$dup2support = true;
			} elseif (isset($dup2file) &&
					\file_exists($dup2file) &&
					\function_exists('dl') &&
					\is_callable('dl')) {
					if (\dl($dup2file) && \is_callable('dup2')) {
						$dup2support = true;
					}
			}
			if ($dup2support) {
				$fd = \fopen('/dev/null', 'r');
				if (!$fd) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$dupresult = \dup2($fd, STDIN);
				if (!$dupresult) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$fd = \fopen('/dev/null', 'w');
				if (!$fd) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$dupresult = \dup2($fd, STDOUT);
				if (!$dupresult) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$dupresult = \dup2($fd, STDERR);
				if (!$dupresult) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$closeresult = \fclose($fd);
				if (!$closeresult) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
			} else {
				$closeresult = \fclose(STDIN);
				if (!$closeresult) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$closeresult = \fclose(STDOUT);
				if (!$closeresult) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$closeresult = \fclose(STDERR);
				if (!$closeresult) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$this->stdin = \fopen('/dev/null', 'r');
				if (!$this->stdin) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$this->stdout = \fopen('/dev/null', 'w');
				if (!$this->stdout) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
				$this->stderr = \fopen('/dev/null', 'w');
				if (!$this->stderr) {
					/**
					 * @todo Error handling is needed here.
					 */
				}
			}

			$daemon->initialize();

			\PHP\OS\Signal::send(\posix_getppid(), Signal::SIGUSR2);

			$this->sid = \posix_setsid();
			\posix_setuid($this->uid);
			\posix_setgid($this->gid);

			$result = $daemon->runAsDaemon();
			\ob_end_flush();
			return $result;
		} else if ($pid > 0) {
			$signal = Signal::wait(array(Signal::SIGUSR2, Signal::SIGCLD,
				Signal::SIGINT, Signal::SIGTERM));
			Signal::replaceBlockMask(array());
			switch ($signal) {
				case Signal::SIGTERM:
				case Signal::SIGINT:
					Signal::send($pid, Signal::SIGTERM);
					$waitsig = Signal::wait(array(Signal::SIGCLD), 1);
					if ($waitsig != Signal::SIGCLD) {
						Signal::send($pid, Signal::SIGKILL);
					} else {
						Process::handleChildTerminations();
					}
					return self::STARTUP_INTERRUPTED;
				case Signal::SIGCLD:
					Process::handleChildTerminations();
					return self::STARTUP_FAILED;
				case Signal::SIGUSR2:
					return self::STARTUP_OK;
			}
		} else {
			return self::STARTUP_FAILED;
		}
	}
}
