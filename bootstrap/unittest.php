<?php

require(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'classes' .
		DIRECTORY_SEPARATOR . 'ClassLoader.php');
ClassLoader::setClassPath(
	array(
		dirname(__DIR__) . DIRECTORY_SEPARATOR . "classes",
		dirname(__DIR__) . DIRECTORY_SEPARATOR . "tests" .
			DIRECTORY_SEPARATOR . "classes"
	)
);
