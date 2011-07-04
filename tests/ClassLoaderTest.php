<?php

/**
 * Test class for ClassLoader.
 */
class ClassLoaderTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Enumerate all classes in a given root directory
	 */
	protected function enumerateAllClasses($rootdir) {
		$result = array();
		$dh = \opendir($rootdir);
		if ($dh) {
			while (($dir = \readdir($dh)) !== false) {
				if (\preg_match('/[a-zA-Z]+/', $dir) && \is_dir($rootdir . \DIRECTORY_SEPARATOR . $dir)) {
					$result = \array_merge($this->enumerateAllClasses($rootdir . \DIRECTORY_SEPARATOR . $dir));
				} else if (\preg_match('/[a-zA-Z]+\.php/', $dir) && \is_file($rootdir . \DIRECTORY_SEPARATOR . $dir)) {
					$result[] = $rootdir . \DIRECTORY_SEPARATOR . $dir;
				}
			}
			\closedir($dh);
		}
		return $result;
	}

	/**
	 * This function attempts to load every class and namespace in order to ensure, that here are no dependency
	 * problems. Also, this includes each and every file in the coverage report.
	 */
	public function testLoadEverything() {
		$classroot = dirname(__DIR__) . \DIRECTORY_SEPARATOR . 'src';
		$files = $this->enumerateAllClasses($classroot);
		foreach ($files as $key => &$value) {
			$files[$key] = str_replace('.php', '', str_replace(DIRECTORY_SEPARATOR, '\\',
					str_replace($classroot . DIRECTORY_SEPARATOR, '', $value)));
		}
		$this->assertGreaterThan(0, \count($files), 'At least one class must be present!');
		foreach ($files as &$class) {
			\ClassLoader::import($class);
			$this->assertTrue(\class_exists('\\' . $class) || \interface_exists('\\' . $class),
					'Class or interface \\' . $class . ' loaded but does not exist!');
		}
	}

	/**
	 * Tests wildcard class loader imports.
	 */
	public function testWildcardImport() {
		\ClassLoader::import('\ClassLoaderTestNamespace\*');
		$this->assertTrue(\class_exists('\ClassLoaderTestNamespace\NamespaceTestClass'),
				'Wildcard import did not load \ClassLoaderTestNamespace\NamespaceTestClass');
	}

	/**
	 * Tests, if a callback function is correctly called
	 */
	public function testClassLoaderCallbackInterface() {
		\ClassLoader::import('\TestClassWithCallback');
		$this->assertTrue(\TestClassWithCallback::getHadCallback(), 'Test callback has not been called!');
		$this->assertTrue(\ClassLoader::hasLoadCallback('TestClassWithCallback'),
				'Test callback class has no callback according to the class loader!');
	}

	/**
	 * Test loading and creating an instance of a dynamic named class
	 */
	public function testLoadAndCreateInstance() {
		$instance = \ClassLoader::loadAndCreateInstance('ClassLoaderInstanceTestClass');
		$this->assertTrue($instance instanceof \ClassLoaderInstanceTestClass,
				'$instance is not an instance of ClassLoaderInstanceTestClass');
	}

	/**
	 * Test creating an instance of a dynamic named class
	 * @depends testLoadAndCreateInstance
	 */
	public function testCreateInstance() {
		$instance = \ClassLoader::createInstance('ClassLoaderInstanceTestClass');
		$this->assertTrue($instance instanceof \ClassLoaderInstanceTestClass,
				'$instance is not an instance of ClassLoaderInstanceTestClass');
	}
}
