<?php

$baseclasses = array(
	'ClassLoaderException',
	'ClassLoaderCallbackInterface',
);
$file = __FILE__;
$imported = array($file);
foreach ($baseclasses as &$baseclass) {
	$file = __DIR__ . DIRECTORY_SEPARATOR . $baseclass . '.php';
	if (!\file_exists($file) || !include($file)) {
		die('Fatal error: failed to load ' . $baseclass);
	}
	$imported[] = $file;
}
\ClassLoader::setImportedFiles($imported);
unset($imported);
unset($baseclasses);
unset($file);
if (isset($baseclass)) {
	unset($baseclass);
}

/**
 * This is the basic class loader for the framework. It implements static
 * loading of all classes required.
 *
 * Note, that there is an autoload mechanism in place, so any projects build
 * for autoloading can use ClassLoader::registerAutoload() to enable this
 * functionality.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
class ClassLoader {
	/**
	 * Internal storage for classpath
	 * @var array
	 */
	protected static $classpath = array();
	/**
	 * List if imported files, so classes don't get imported twice.
	 * @var array of strings
	 */
	protected static $imported = array();

	/**
	 * The queue of namespaces to load. This is implemented so that wildcard
	 * namespaces don't get added twice.
	 * @var array of string
	 */
	protected static $loadQueue = array();

	/**
	 * The queue of classes to call as a load callback.
	 * @var array of string
	 */
	protected static $callbackqueue = array();

	/**
	 * The number of iterations the load cycle has passed.
	 * @var int default 0
	 */
	protected static $loadDepth = 0;

	/**
	 * Set the classpath for the loader
	 * @param array $classpath
	 * @internal This method should never be used inside OOP environment
	 * @codeCoverageIgnore
	 */
	public static function setClassPath($classpath) {
		if (is_array($classpath)) {
			self::$classpath = $classpath;
		} else {
			self::$classpath = array($classpath);
		}
	}

	/**
	 * Pre-set imported files list.
	 * @param array $imported
	 * @internal This method should never be used inside OOP environment
	 * @codeCoverageIgnore
	 */
	public static function setImportedFiles($imported = array()) {
		self::$imported = $imported;
	}

	/**
	 * Tests, if a loaded class has a load callback. This is utilized to provide
	 * plugin functionality
	 * @param string $className
	 * @return bool
	 */
	public static function hasLoadCallback($className) {
		$className = \ltrim($className, '\\');
		if (\class_exists($className, false)
				&& \in_array("ClassLoaderCallbackInterface",
						\class_implements($className, false))) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * If a class has a load callback, this function calls it.
	 * @param string $className
	 */
	protected static function callbackClass($className) {
		if (self::hasLoadCallback($className)) {
			\call_user_func($className . '::onClassLoaded');
		}
	}

	/**
	 * Internal file loader
	 * @param string $file
	 */
	protected static function loadFile($file, $className) {
		if (!\in_array($file, self::$imported)) {
			self::$imported[] = $file;
			if (\is_file($file) && \is_readable($file)) {
				if (!include($file)) {
					throw new ClassLoaderException("Include failed: " . $file);
				} else {
					self::$callbackqueue[] = $className;
				}
			}
		}
	}

	/**
	 * Get all candidates for a given namespace.
	 * @param string $namespace
	 * @return array
	 */
	public static function getCandidates($namespace) {
		$files = array();
		foreach (self::$classpath as $path) {
			$namespace = \ltrim($namespace, '\\');
			$path = \str_replace('\\', \DIRECTORY_SEPARATOR, $path .
					\DIRECTORY_SEPARATOR . $namespace);
			if (\substr($path, -2) == '\\*' || \substr($path, -2) == '/*') {
				$path = \substr($path, 0, \strlen($path) - 2);
				if (\is_dir($path)) {
					$fh = \opendir($path);
					if ($fh) {
						while ($file = readdir($fh)) {
							if (\preg_match("/^(?P<class>[a-zA-Z0-9]+)\.php$/", $file, $matches)) {
								$files[] = array(
									'file' => $path . \DIRECTORY_SEPARATOR . $file,
									'class' => \substr($namespace, 0, \strlen($namespace) - 2)
										. '\\' . $matches['class']);
							}
						}
						\closedir($fh);
					}
				}
			} else {
				$files[] = array(
					'file' => $path . '.php',
					'class' => $namespace);
			}
		}
		\sort($files);
		return $files;
	}

	/**
	 * Import class or classes from namespace
	 * @param string $namespace
	 */
	public static function import($namespace) {
		/**
		 * Put the caller into the imported list so it doesn't get loaded
		 * twice.
		 */
		$backtrace = \debug_backtrace();
		$file = $backtrace[0]['file'];
		if (!\in_array($file, self::$imported)) {
			self::$imported[] = $file;
		}

		/**
		 * Keep track of load depth so load callbacks can be run after the last
		 * import is finished.
		 */
		self::$loadDepth++;

		/**
		 * Enumerate candidates.
		 */
		$files = self::getCandidates($namespace);
		foreach ($files as $file) {
			if (!\in_array($file, self::$imported)) {
				self::loadFile($file['file'], $file['class']);
			}
		}
		self::$loadDepth--;
		if (self::$loadDepth == 0) {
			foreach (self::$callbackqueue as $key => $className) {
				self::callbackClass($className);
				unset(self::$callbackqueue[$key]);
			}
		}
	}

	/**
	 * Create an instance of a given class. This function DOES load the
	 * class, you have to do that with import()
	 * @param string $classname
	 * @param mixed $arg1
	 * @param mixed $arg2
	 * @param mixed $argn
	 * @return object
	 */
	public static function loadAndCreateInstance() {
		$arguments = \func_get_args();
		$classname = \array_shift($arguments);
		self::import($classname);
		$reflect = new \ReflectionClass($classname);
		$instance = $reflect->newInstance($arguments);
		return $instance;
	}

	/**
	 * Create an instance of a given class. This function does NOT load the
	 * class, you have to do that with import()
	 * @param string $classname
	 * @param mixed $arg1
	 * @param mixed $arg2
	 * @param mixed $argn
	 * @return object
	 */
	public static function createInstance() {
		$arguments = \func_get_args();
		$classname = \array_shift($arguments);
		$reflect = new \ReflectionClass($classname);
		$instance = $reflect->newInstance($arguments);
		return $instance;
	}

	/**
	 * Autoload a given namespace. This is not automatically enabled,
	 * the application must do so by calling ClassLoader::registerAutoload
	 * @param string $namespace
	 */
	public static function autoload($namespace) {
		self::import('\\' . $namespace);
	}

	/**
	 * Register the ClassLoader for autoloading. This is not automatically done
	 * so any projects using autoload functionality must use this function to
	 * enable it.
	 */
	public static function registerAutoload() {
		\spl_autoload_register('\ClassLoader::autoload');
	}
}
