<?php
/**
 * @author Janos Pasztor <janos@janoszen.hu>
 * @copyright Janos Pasztor (c) 2011
 * @mainpage
 * <h1>Project goal</h1>
 * <p>The aim of this project is to provide an easily usable interface to IPv6 addresses and DNS queries. This code is
 * written to help the wide spread implementation of IPv6 and is therefore available under a number of free / open
 * source licenses. (See below for details.)</p>
 * <h1>Working with the code</h1>
 * <p>Working with the code is simple. You need to put it into whatever framework you are using and autoload the classes.
 * It comes down to two classes:</p>
 * <ul>
 *	<li>INET4Address - This is your IPv4 address.</li>
 *	<li>INET6Address - This is your IPv6 address.</li>
 * </ul>
 * <p>You can find the API docs in the docs/doxygen folder.</p>
 * <p>If you want to build the code, you are going to need a working git client as well as the following software:</p>
 * <ul>
 *	<li>Apache Ant</li>
 *	<li>PHPUnit</li>
 *	<li>PDepend</li>
 *	<li>PHPMD</li>
 *	<li>Doxygen</li>
 * </ul>
 * <h1>Coding standards</h1>
 * <p>The rules are pretty simple:</p>
 * <ul>
 *	<li>All code is to be indented by exactly one tab per level. (Sorry space-fans, the tab character has been working
 *	in all editors for over a decade now.)</li>
 *	<li>All opening curly brackets are to be written on the same line as the statement before it.</li>
 *	<li>Use spaces before opening brackets, but not after them.</li>
 *	<li>Use spaces before and after the equals sign.</li>
 *	<li>No lines longer, than 120 characters.</li>
 *	<li>No magic! Clean, readable code!</li>
 *	<li>By the penalty of public harassment <strong>comment and unit test your code</strong>!</li>
 * </ul>
 * <h1>Contributing</h1>
 * <p>If you have ideas for improvement, please <a href="https://github.com/janoszen/PHPIPv6Utils/issues">submit an
 * issue</a>. If you have code to contribute, fork my project and then submit a
 * <a href="https://github.com/janoszen/PHPIPv6Utils/pulls">pull request</a>. I will attend to it as soon as
 * possible.</p>
 * <p>By submitting a pull request, you agree, that all contributed code will be available under the terms of the
 * copyright notice below. You grant the original author (János Pásztor) unrevocable rights to re-license the code under
 * the terms of any open source license acknowledged as such by the <a href="http://www.opensource.org/">Open Source
 * Initiative</a>.</p>
 * <h1>Copyright</h1>
 * <p>All original code in the src and tests directory is copyrighted by me (János Pásztor). All code contributed via
 * GitHub pull requests is copyrighted by the original author.</p>
 * <p>All code in this repository is freely available under the terms of one of the following licenses:</p>
 * <ul>
 *	<li>BSD Licence</li>
 *	<li>GNU General Public License v 2.0 or newer</li>
 *	<li>GNU Lesser General Public License v 2.1 or newer</li>
 * </ul>
 * <p>Your choice. :)</p>
 */

namespace PHP\Net;