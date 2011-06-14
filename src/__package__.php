<?php
/**
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @license http://creativecommons.org/licenses/BSD/
 * @mainpage
 * <h1>A word of warning</h1>
 *
 * <p><strong>This project is experimental.</strong> There are absoluely <em>no
 * warranties</em> on performance or code stability. You are free to
 * <a href="https://github.com/janoszen/Alternative-Class-Repository/issues">open issues</a>
 * on <a href="https://github.com/janoszen/Alternative-Class-Repository">GitHub</a>,
 * but being not only an open source, but also a hobby project, I may or may not
 * resolve anything you report.</p>
 *
 * <h1>Yet another framework?</h1>
 * <p>Why create a PHP framework, when there are at least a zillion out there and half
 * a dozen mainstream ones? The answer is quite easy: both the PEAR and the PHP
 * frameworks out there have more or less poor quality standards. Skipping error
 * handling and type checking in basic functions such as math, json, etc. has
 * become common due to the fact, that PHP allows it. This framework tries to
 * enforce the most strict rules possible with PHP. Notices will become fatal
 * crashes, warnings will become exceptions. This way code quality can be ensured
 * from the foundation.</p>
 *
 * <h1>Application server mode</h1>
 *
 * <p>There is an other reason for writing this framework. Even though Zend loudly
 * advertizes Zend Server as an application server, it is not. Opcode caches and
 * optimizers may help with parsing the code, but they don't alleviate the fact,
 * that in most cases 50-80% of the code is about initializing something. Therefore
 * PHP code running on a per-request basis will never be as fast as Django for
 * example.</p>
 *
 * <p>This framework tries to provide a layer for that. It runs as a daemon
 * implementing multiple protocols, which webservers can use for connecting it.
 * Even though this layer may be skipped and skipping it is a supported way of
 * using it, it provides speed benefits if you can afford a virtual or dedicated
 * server for running it.</p>
 *
 * <p>Because of this design concept, autoloading is not enabled by default. If you
 * wish to create a project with autoloading support, you must call
 * registerAutoload() to enable it. Please note, that this is heavily recommended
 * against when using this framework as a daemon, because potential PHP compile
 * errors don't occur at startup time. Also, if you don't load everything at
 * startup, the first couple of page requests will be slower, thus degrading the
 * positive effect of the application server mode.</p>
 *
 * <h1>How to build</h1>
 *
 * <p>The project includes an Apache Ant build.xml file, which uses <a href="http://www.doxygen.org/">Doxygen</a>,
 * <a href="http://pdepend.org/">PDepend</a>, <a href="http://pear.php.net/package/PHP_CodeSniffer">PHPCS</a>,
 * <a href="http://phpmd.org/">PHPMD</a> and <a href="http://www.phpunit.de">PHPUnit</a>.
 * These must be installed in order to run a successful build.</p>
 *
 * <h1>How to use</h1>
 *
 * <p>Since this project is pretty much experimental, it's up to you to find out
 * your best way to use it. You could just use the classes, or you could build
 * a complete application around it.</p>
 */
