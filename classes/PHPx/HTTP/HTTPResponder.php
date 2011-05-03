<?php

namespace PHPx\HTTP;

abstract class HTTPResponder {
	function onHeadersReceived(HTTPServer $server,
			HTTPRequest $request,
			HTTPResponse $response) {
	}

	function onChunkReceived(HTTPServer $server,
			HTTPRequest $request,
			HTTPResponse $response) {
	}

	function onRequestAbort(HTTPServer $server,
			HTTPRequest $request,
			HTTPResponse $response) {
	}

	function onRequestComplete(HTTPServer $server,
			HTTPRequest $request,
			HTTPResponse $response) {
	}

	function onHeadersSent(HTTPServer $server,
			HTTPRequest $request,
			HTTPResponse $response) {
		
	}

	function onChunkSent(HTTPServer $server,
			HTTPRequest $request,
			HTTPResponse $response) {
		
	}

	function onResponseSent(HTTPServer $server,
			HTTPRequest $request,
			HTTPResponse $response) {
		
	}
}