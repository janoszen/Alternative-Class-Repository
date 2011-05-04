<?php

/**
 * This is the daemon initialization class, which runs the basic initialization.
 * Once init is complete, it hands over control to the configured application.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class Init {
	/**
	 * Classpath cache
	 * @var array
	 */
	protected $classpath = array();
	/**
	 * Command line arguments
	 * @var array
	 */
	protected $arguments = array();

	/**
	 * Constructor, which reads command line arguments.
	 */
	function __construct() {
		foreach ($_SERVER['argv'] as $value) {
			$value = \explode('=', $value, 2);
			$value[0] = \ltrim($value[0], '-');
			if (\array_key_exists(1, $value)) {
				$this->arguments[$value[0]] = $value[1];
			} else {
				$this->arguments[$value[0]] = true;
			}
		}
	}
	
	/**
	 * A fatal, unrecoverable error occured during initialization. This function
	 * exists out of the daemon effectively terminating all inner workings.
	 * @param string $error
	 */
	protected function error($error, $backtrace = array()) {
		\fwrite(STDERR, $error . PHP_EOL);
		if (!\is_array($backtrace) || !\count($backtrace)) {
			$backtrace = \debug_backtrace();
			\array_shift($backtrace);
		}
		foreach($backtrace as &$btentry) {
			$line = ' at ';
			if (\array_key_exists('class', $btentry)) {
				$line .= $btentry['class'] . '::' . $btentry['function'];
			} else if (\array_key_exists('function', $btentry)) {
				$line .= $btentry['function'];
			}
			if (\array_key_exists('file', $btentry)) {
				$line .= '(' . $btentry['file'];
				if (\array_key_exists('line', $btentry)) {
					 $line .= ':' . $btentry['line'];
				}
				$line .= ')';
			}
			\fwrite(STDERR, $line . PHP_EOL);
		}
		exit(1);
	}

	/**
	 * Get a variable from either command line or environment. If the given
	 * variable is empty and $fail is set to true, error() is called. In other
	 * words, the basic environment variables MUST be defined!
	 * @param string $variable
	 */
	protected function getEnv($variable, $fail = true) {
		if (\array_key_exists($variable, $this->arguments)) {
			return $this->arguments[$variable];
		}
		$value = \getenv($variable);
		if (!$value && $fail) {
			$this->error('Environment variable ' . $variable . ' is not set!');
		}
		return $value;
	}

	/**
	 * Get the classpath from the CLASSPATH environment variable. If it is not
	 * defined, the include_path php.ini setting is used.
	 * @return array
	 */
	protected function getClassPath() {
		if (!$this->classpath) {
			$classpath = $this->getEnv('CLASSPATH', false);
			if (PHP_OS == 'Windows') {
				$classpathSeparator = ';';
			} else {
				$classpathSeparator = ':';
			}
			if (!$classpath) {
				$classpath = \ini_get('include_path');
			}
			$this->classpath = \explode($classpathSeparator, $classpath);
		}
		return $this->classpath;
	}

	/**
	 * This is the basic error handler, which exits on all errors. This is
	 * provided as a fail-safe and should be overridden by applications.
	 */
	public function errorHandler($errno, $errstr, $errfile, $errline) {
		$errtype = 'Unspecified Error';
		switch ($errno) {
			case E_ERROR:
				$errtype = 'Fatal error';
				break;
			case E_WARNING:
			case E_USER_WARNING:
				$errtype = 'Warning';
				break;
			case E_NOTICE:
			case E_USER_NOTICE:
				$errtype = 'Notice';
				break;
			case E_DEPRECATED:
				$errtype = 'Deprecated error';
				break;
		}
		$this->error($errtype . ': ' . $errstr . ' in ' . $errfile . ' line ' . $errline);
	}

	/**
	 * Basic exception handler, which exits on all exceptions. This is provided
	 * as a fail-safe and should be overridden by applications.
	 * @param Exception $exception
	 */
	public function exceptionHandler(Exception $exception) {
		$this->error('Uncaught ' . \get_class($exception) . ' with message ' .
				$exception->getMessage() . ' from ' . $exception->getFile() .
				' line ' . $exception->getLine(), $exception->getTrace());
	}

	/**
	 * Set up basic error handling so the application doesn't crash
	 * unexpectedly.
	 */
	public function setup() {
		\set_exception_handler(array($this, 'exceptionHandler'));
		\set_error_handler(array($this, 'errorHandler'), E_ALL);
	}

	/**
	 * Load the ClassLoader using the defined CLASSPATH directories. If no
	 * usable ClassLoader is found, the application fails out.
	 */
	public function load() {
		foreach ($this->getClassPath() as $classpath) {
			$loader = $classpath . DIRECTORY_SEPARATOR . 'ClassLoader.php';
			if (\file_exists($loader) && \is_readable($loader)) {
				include($classpath . DIRECTORY_SEPARATOR . 'ClassLoader.php');
			}
		}
		if (!\class_exists('ClassLoader', false)) {
			$this->error('No usable ClassLoader!');
		}
		ClassLoader::setClassPath($this->getClassPath());
	}

	/**
	 * Run the application.
	 */
	public function run() {
		$application = ClassLoader::loadAndCreateInstance($this->getEnv('application'));
		return $application->run();
	}

	/**
	 * Launch the application. This is a static function to keep the global
	 * variable space clean.
	 */
	public static function launch() {
		$init = new Init();
		$init->setup();
		$init->load();
		$ret = $init->run();
		if (\is_int($ret)) {
			exit($ret);
		}
	}
}

Init::launch();