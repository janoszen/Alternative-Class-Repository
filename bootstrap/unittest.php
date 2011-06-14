<?php

$GLOBALS['classroot'] = dirname(__DIR__) . \DIRECTORY_SEPARATOR . "src";
$GLOBALS['testroot'] = dirname(__DIR__) . \DIRECTORY_SEPARATOR . "tests";

require($GLOBALS['classroot'] . \DIRECTORY_SEPARATOR . 'ClassLoader.php');
\ClassLoader::setClassPath(
	array(
		$GLOBALS['classroot'],
		$GLOBALS['testroot'],
	)
);
