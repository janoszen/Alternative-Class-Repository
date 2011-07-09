<?php

namespace PHP\OS;

\ClassLoader::import('PHP\Lang\*');
\ClassLoader::import('PHP\IO\*');
\ClassLoader::import('PHP\OS\*');

/**
 * This is a daemonizing toolkit for classes, that implement PHP\OS\Daemon.
 * It tries to follow best practices to date as far as PHP allows them.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class DaemonContext extends \PHP\Lang\Object {
	/**
	 * The current working directory. This directory is chdir()-ed into AFTER
	 * the chroot() has occured.
	 * @var \PHP\IO\File
	 */
	protected $workingDir;
	/**
	 * This is the UID the application should switch to.
	 * @var int
	 */
	protected $uid;
	/**
	 * This is the GID the application should switch to.
	 * @var int
	 */
	protected $gid;
	/**
	 * This is the directory the application should chroot into. Please note,
	 * that if no PHP interpreter is provided within the chroot, errors may
	 * occur with specific PHP features.
	 * @var \PHP\IO\File
	 */
	protected $chroot;
	/**
	 * This is an internal variable to hold the new STDIN file descriptor
	 * @var resource
	 * @internal
	 */
	protected $stdin;
	/**
	 * This is an internal variable to hold the new STDOUT file descriptor
	 * @var resource
	 * @internal
	 */
	protected $stdout;
	/**
	 * This is an internal variable to hold the new STDERR file descriptor
	 * @var resource
	 * @internal
	 */
	protected $stderr;

	/**
	 * Application has loaded successfully and most presumably is able to run.
	 */
	const STARTUP_OK = 0;
	/**
	 * Application startup has failed. See logs for details.
	 */
	const STARTUP_FAILED = 1;
	/**
	 * Application startup has been interrupted by for eg. Ctrl+C
	 */
	const STARTUP_INTERRUPTED = 2;

	function __construct() {
		parent::__construct();
		$this->workingDir = new \PHP\IO\File('/');
		$this->uid = \posix_getuid();
		$this->gid = \posix_getgid();
		$this->chroot = new \PHP\IO\File('/');
	}

	/**
	 * Set the current working directory for the application. This directory
	 * is chdir()-ed into after chroot().
	 * @param \PHP\IO\File $workingDir
	 * @throws \PHP\Lang\ValueError if the directory doesn't exist.
	 * @return \PHP\OS\DaemonContext
	 */
	function setWorkingDir(\PHP\IO\File $workingDir) {
		if (!$workingDir->isDirectory()) {
			throw new \PHP\Lang\ValueError($workingDir->getPath(), 'existing directory');
		}
		$this->workingDir = $workingDir;
		return $this;
	}

	/**
	 * Returns the specified CWD.
	 * @return \PHP\IO\File
	 */
	function getWorkingDir() {
		return $this->workingDir;
	}

	/**
	 * Set the UID for the application.
	 * @param int $uid
	 * @throws \PHP\Lang\TypeError if the UID is not an integer
	 * @throws \PHP\Lang\ValueError if the UID is not positive
	 * @return \PHP\OS\DaemonContext
	 */
	function setUid($uid) {
		if (!\is_int($uid)) {
			throw new \PHP\Lang\TypeError($uid, 'integer');
		}
		if ($uid < 0) {
			throw new \PHP\Lang\ValueError($uid, 'positive integer');
		}
		$this->uid = $uid;
		return $this;
	}

	/**
	 * Returns the UID the application is supposed to run under.
	 * @return int
	 */
	function getUid() {
		return $this->uid;
	}

	/**
	 * Set the GID for the application.
	 * @param int $uid
	 * @throws \PHP\Lang\TypeError if the GID is not an integer
	 * @throws \PHP\Lang\ValueError if the GID is not positive
	 * @return \PHP\OS\DaemonContext
	 */
	function setGid($gid) {
		if (!\is_int($gid)) {
			throw new \PHP\Lang\TypeError($gid, 'integer');
		}
		if ($gid < 0) {
			throw new \PHP\Lang\ValueError($gid, 'positive integer');
		}
		$this->gid = $gid;
		return $this;
	}

	/**
	 * Returns the GID the application is supposed to run under.
	 * @return int
	 */
	function getGid() {
		return $this->gid;
	}

	/**
	 * Set the chroot() directory
	 * @param \PHP\IO\File $chroot
	 * @throws \PHP\Lang\ValueError if the directory provided does not exist.
	 * @return \PHP\OS\DaemonContext
	 */
	function setChroot(\PHP\IO\File $chroot) {
		if (!$chroot->isDirectory()) {
			throw new \PHP\Lang\ValueError($chroot->getPath(), 'existing directory');
		}
		$this->chroot = $chroot;
		return $this;
	}

	/**
	 * Return the chroot() directory
	 * @return \PHP\IO\File
	 */
	function getChroot() {
		return $this->chroot;
	}

	/**
	 * Output handler function stub.
	 * @todo implement this function to do something sensible.
	 * @param string $output
	 */
	function outputHandler($output) {
	}

	/**
	 * Run an application as a daemon. Will either return as parent or child.
	 * If it returns as parent, the startup status is returned.
	 * @param \PHP\OS\Daemon $daemon
	 * @return int
	 */
	function runAsDaemon(Daemon $daemon) {
		Signal::block(new \PHP\Util\Collection(array(Signal::SIGUSR2,
			Signal::SIGCLD, Signal::SIGINT, Signal::SIGTERM)));
		$pid = Process::fork();
		if ($pid == 0) {
			Signal::replaceBlockMask(new \PHP\Util\Collection(array()));
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
			$signal = Signal::wait(new \PHP\Util\Collection(array(
				Signal::SIGUSR2, Signal::SIGCLD, Signal::SIGINT,
				Signal::SIGTERM)));
			Signal::replaceBlockMask(new \PHP\Util\Collection(array()));
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
