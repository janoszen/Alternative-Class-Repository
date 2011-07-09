<?php

namespace PHP\OS;

/**
 * This interface ensures, that all functions required by PHP\OS\DaemonContext
 * exist.
 *
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 */
interface Daemon {
	function load();
	function initialize();
	function runAsDaemon();
}
