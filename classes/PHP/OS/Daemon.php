<?php

namespace PHP\OS;

interface Daemon {
	function load();
	function initialize();
	function runAsDaemon();
}
