<?php

$classroot = dirname(__DIR__) . \DIRECTORY_SEPARATOR . "src";
$testroot = dirname(__DIR__) . \DIRECTORY_SEPARATOR . "tests";

require($classroot . \DIRECTORY_SEPARATOR . 'ClassLoader.php');
\ClassLoader::setClassPath(
	array(
		$classroot,
		$testroot,
	)
);
unset($classroot);
unset($testroot);

define('TESTDATADIR', dirname(__DIR__) . \DIRECTORY_SEPARATOR . 'testdata');
define('TESTTMPDIR', dirname(__DIR__) . \DIRECTORY_SEPARATOR . 'testdata' . \DIRECTORY_SEPARATOR . 'tmp');
