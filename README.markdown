A word of warning
=================

**This project is experimental.** There are absoluely *no warranties* on performance
or code stability. You are free to [open issues](https://github.com/janoszen/Alternative-Class-Repository/issues)
on [GitHub](https://github.com/janoszen/Alternative-Class-Repository), but being not only an
open source, but also a hobby project, I may or may not resolve anything you
report.

Yet another framework?
======================

Why create a PHP framework, when there are at least a zillion out there and half
a dozen mainstream ones? The answer is quite easy: both the PEAR and the PHP
frameworks out there have more or less poor quality standards. Skipping error
handling and type checking in basic functions such as math, json, etc. has
become common due to the fact, that PHP allows it. This framework tries to
enforce the most strict rules possible with PHP. Notices will become fatal
crashes, warnings will become exceptions. This way code quality can be ensured
from the foundation.

Application server mode
=======================

There is an other reason for writing this framework. Even though Zend loudly
advertizes Zend Server as an application server, it is not. Opcode caches and
optimizers may help with parsing the code, but they don't alleviate the fact,
that in most cases 50-80% of the code is about initializing something. Therefore
PHP code running on a per-request basis will never be as fast as Django for
example.

This framework tries to provide a layer for that. It runs as a daemon
implementing multiple protocols, which webservers can use for connecting it.
Even though this layer may be skipped and skipping it is a supported way of
using it, it provides speed benefits if you can afford a virtual or dedicated
server for running it.

Because of this design concept, autoloading is not enabled by default. If you
wish to create a project with autoloading support, you must call
registerAutoload() to enable it. Please note, that this is heavily recommended
against when using this framework as a daemon, because potential PHP compile
errors don't occur at startup time. Also, if you don't load everything at
startup, the first couple of page requests will be slower, thus degrading the
positive effect of the application server mode.

How to build
============

The project includes an Apache Ant build.xml file, which uses
[Doxygen](http://doxygen.org/), [PDepend](http://pdepend.org),
[PHPCS](http://pear.php.net/package/PHP_CodeSniffer/), [PHPMD](http://phpmd.org)
and [PHPUnit](http://phpunit.de). These must be installed in order to run a
successful build.

How to use
==========

Since this project is pretty much experimental, it's up to you to find out
your best way to use it. You could just use the classes, or you could build
a complete application around it.