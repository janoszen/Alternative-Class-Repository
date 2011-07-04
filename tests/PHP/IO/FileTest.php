<?php

namespace PHP\IO;

\ClassLoader::import('PHP\IO\File');

/**
 * Test class for PHP\IO\File.
 */
class FileTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Test, if the path separator is a forward or backwards slash.
	 */
	public function testGetPathSeparator() {
		$this->assertTrue(\in_array(File::getPathSeparator(), array('/', '\\')));
	}

	/**
	 * Tests the creation of a new file.
	 */
	public function testCreateNewFile() {
		$testfile = \TESTTMPDIR . File::getPathSeparator() . \time();
		$f = new File($testfile);
		$f->createNewFile();
		$this->assertTrue(\file_exists($testfile));
		\unlink($testfile);
	}

	/**
	 * Tests, if the current process can read a specified file
	 */
	public function testCanRead() {
		$f = new File(__FILE__);
		$this->assertTrue($f->canRead(), 'PHP can\'t read the current file.');
	}

	/**
	 * Tests, if the process can write into the TMPTESTDIR
	 */
	public function testCanWrite() {
		$f = new File(\TESTTMPDIR);
		$this->assertTrue($f->canWrite(), 'Test TMP dir is not writable or File::canWrite implementation is buggy!');
	}

	/**
	 * Test, if the absolute file name
	 */
	public function testGetAbsoluteFile() {
		$f = new File('.');
		$this->assertEquals(getcwd(), $f->getAbsoluteFile(), 'Absolute file for . is ' . $f->getAbsoluteFile()
				. ' and does not match ' . getcwd());
	}

	/**
	 * Get absolute path name
	 */
	public function testGetAbsolutePath() {
		$f = new File('.');
		$this->assertEquals(dirname(getcwd()), $f->getAbsolutePath(), 'Absolute path for . is ' . $f->getAbsolutePath()
				. ' and does not match ' . dirname(getcwd()));
	}

	/**
	 * @todo Implement testGetCanonicalFile().
	 */
	public function testGetCanonicalFile() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @todo Implement testGetCanonicalPath().
	 */
	public function testGetCanonicalPath() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @todo Implement testGetPath().
	 */
	public function testGetPath() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * @todo Implement testIsAbsolute().
	 */
	public function testIsAbsolute() {
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
				'This test has not been implemented yet.'
		);
	}

	/**
	 * Tests, if directories are correctly detected.
	 */
	public function testIsDirectory() {
		$f = new File(\TESTDATADIR);
		$this->assertTrue($f->isDirectory());
		$f = new File(\TESTDATADIR . \DIRECTORY_SEPARATOR . 'testfile');
		$this->assertFalse($f->isDirectory());
	}

	/**
	 * Tests, if files are correcly detected
	 */
	public function testIsFile() {
		$this->markTestIncomplete();
		$f = new File(\TESTDATADIR);
		$this->assertFalse($f->isFile(), \TESTDATADIR . ' is a file?');
		$f = new File(\TESTDATADIR . \DIRECTORY_SEPARATOR . 'testfile');
		$this->assertTrue($f->isFile(), \TESTDATADIR . \DIRECTORY_SEPARATOR . 'testfile is not a file?');
	}

	/**
	 * Test creation of a directory
	 */
	public function testMkdir() {
		$this->markTestIncomplete();
		$dir = \TESTTMPDIR . File::getPathSeparator() . 'testdir';
		$f = new File($dir);
		$this->assertFalse($f->isDirectory());
		$f->mkdir();
		$this->assertTrue($f->isDirectory());
		$f->unlink();
		$this->assertFalse($f->isDirectory());
	}

	/**
	 * Test renaming a file
	 */
	public function testRenameTo() {
		$this->markTestIncomplete();
		$file1 = \TESTTMPDIR . File::getPathSeparator() . 'test1';
		$file2 = \TESTTMPDIR . File::getPathSeparator() . 'test2';
		$f1 = new File($file1);
		$f2 = new File($file2);
		$f1->createNewFile();
		$this->assertTrue($f1->isFile());
		$this->assertFalse($f2->isFile());
		$f1->renameTo($f2);
		$this->assertFalse($f1->isFile());
		$this->assertTrue($f2->isFile());
		$f2->unlink();
	}
}
