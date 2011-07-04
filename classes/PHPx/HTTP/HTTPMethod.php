<?php

namespace PHPx\HTTP;

class HTTPMethod {
	/**
	 * The OPTIONS method represents a request for information about the
	 * communication options available on the request/response chain identified
	 * by the Request-URI. This method allows the client to determine the
	 * options and/or requirements associated with a resource, or the
	 * capabilities of a server, without implying a resource action or
	 * initiating a resource retrieval.
	 * 
	 * Responses to this method are not cacheable.
	 * 
	 * If the OPTIONS request includes an entity-body (as indicated by the
	 * presence of Content-Length or Transfer-Encoding), then the media type
	 * MUST be indicated by a Content-Type field. Although this specification
	 * does not define any use for such a body, future extensions to HTTP might
	 * use the OPTIONS body to make more detailed queries on the server. A
	 * server that does not support such an extension MAY discard the request
	 * body.
	 * 
	 * If the Request-URI is an asterisk ("*"), the OPTIONS request is intended
	 * to apply to the server in general rather than to a specific resource.
	 * Since a server's communication options typically depend on the resource,
	 * the "*" request is only useful as a "ping" or "no-op" type of method; it
	 * does nothing beyond allowing the client to test the capabilities of the
	 * server. For example, this can be used to test a proxy for HTTP/1.1
	 * compliance (or lack thereof).
	 * 
	 * If the Request-URI is not an asterisk, the OPTIONS request applies only
	 * to the options that are available when communicating with that resource.
	 * 
	 * A 200 response SHOULD include any header fields that indicate optional
	 * features implemented by the server and applicable to that resource
	 * (e.g., Allow), possibly including extensions not defined by this
	 * specification. The response body, if any, SHOULD also include information
	 * about the communication options. The format for such a body is not
	 * defined by this specification, but might be defined by future extensions
	 * to HTTP. Content negotiation MAY be used to select the appropriate
	 * response format. If no response body is included, the response MUST
	 * include a Content-Length field with a field-value of "0".
	 * 
	 * The Max-Forwards request-header field MAY be used to target a specific
	 * proxy in the request chain. When a proxy receives an OPTIONS request on
	 * an absoluteURI for which request forwarding is permitted, the proxy MUST
	 * check for a Max-Forwards field. If the Max-Forwards field-value is zero
	 * ("0"), the proxy MUST NOT forward the message; instead, the proxy SHOULD
	 * respond with its own communication options. If the Max-Forwards
	 * field-value is an integer greater than zero, the proxy MUST decrement
	 * the field-value when it forwards the request. If no Max-Forwards field
	 * is present in the request, then the forwarded request MUST NOT include a
	 * Max-Forwards field. 
	 * 
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.2
	 */
	const METHOD_OPTIONS = 'OPTIONS';
	/**
	 * The GET method means retrieve whatever information (in the form of an
	 * entity) is identified by the Request-URI. If the Request-URI refers to a
	 * data-producing process, it is the produced data which shall be returned
	 * as the entity in the response and not the source text of the process,
	 * unless that text happens to be the output of the process.
	 *
	 * The semantics of the GET method change to a "conditional GET" if the
	 * request message includes an If-Modified-Since, If-Unmodified-Since,
	 * If-Match, If-None-Match, or If-Range header field. A conditional GET
	 * method requests that the entity be transferred only under the
	 * circumstances described by the conditional header field(s). The
	 * conditional GET method is intended to reduce unnecessary network usage by
	 * allowing cached entities to be refreshed without requiring multiple
	 * requests or transferring data already held by the client.
	 *
	 * The semantics of the GET method change to a "partial GET" if the request
	 * message includes a Range header field. A partial GET requests that only
	 * part of the entity be transferred, as described in section 14.35. The
	 * partial GET method is intended to reduce unnecessary network usage by
	 * allowing partially-retrieved entities to be completed without
	 * transferring data already held by the client.
	 *
	 * The response to a GET request is cacheable if and only if it meets the
	 * requirements for HTTP caching described in section 13.
	 *
	 * See section 15.1.3 for security considerations when used for forms.
	 *
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.3
	 */
	const METHOD_GET = 'GET';
	/**
	 * The HEAD method is identical to GET except that the server MUST NOT
	 * return a message-body in the response. The metainformation contained in
	 * the HTTP headers in response to a HEAD request SHOULD be identical to the
	 * information sent in response to a GET request. This method can be used
	 * for obtaining metainformation about the entity implied by the request
	 * without transferring the entity-body itself. This method is often used
	 * for testing hypertext links for validity, accessibility, and recent
	 * modification.
	 *
	 * The response to a HEAD request MAY be cacheable in the sense that the
	 * information contained in the response MAY be used to update a previously
	 * cached entity from that resource. If the new field values indicate that
	 * the cached entity differs from the current entity (as would be indicated
	 * by a change in Content-Length, Content-MD5, ETag or Last-Modified), then
	 * the cache MUST treat the cache entry as stale.
	 *
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.4
	 */
	const METHOD_POST = 'POST';
	/**
	 * The PUT method requests that the enclosed entity be stored under the
	 * supplied Request-URI. If the Request-URI refers to an already existing
	 * resource, the enclosed entity SHOULD be considered as a modified version
	 * of the one residing on the origin server. If the Request-URI does not
	 * point to an existing resource, and that URI is capable of being defined
	 * as a new resource by the requesting user agent, the origin server can
	 * create the resource with that URI. If a new resource is created, the
	 * origin server MUST inform the user agent via the 201 (Created) response.
	 * If an existing resource is modified, either the 200 (OK) or 204 (No
	 * Content) response codes SHOULD be sent to indicate successful completion
	 * of the request. If the resource could not be created or modified with the
	 * Request-URI, an appropriate error response SHOULD be given that reflects
	 * the nature of the problem. The recipient of the entity MUST NOT ignore
	 * any Content-* (e.g. Content-Range) headers that it does not understand or
	 * implement and MUST return a 501 (Not Implemented) response in such cases.
	 *
	 * If the request passes through a cache and the Request-URI identifies one
	 * or more currently cached entities, those entries SHOULD be treated as
	 * stale. Responses to this method are not cacheable.
	 *
	 * The fundamental difference between the POST and PUT requests is reflected
	 * in the different meaning of the Request-URI. The URI in a POST request
	 * identifies the resource that will handle the enclosed entity. That
	 * resource might be a data-accepting process, a gateway to some other
	 * protocol, or a separate entity that accepts annotations. In contrast, the
	 * URI in a PUT request identifies the entity enclosed with the request --
	 * the user agent knows what URI is intended and the server MUST NOT attempt
	 * to apply the request to some other resource. If the server desires that
	 * the request be applied to a different URI, it MUST send a 301 (Moved
	 * Permanently) response; the user agent MAY then make its own decision
	 * regarding whether or not to redirect the request.
	 *
	 * A single resource MAY be identified by many different URIs. For example,
	 * an article might have a URI for identifying "the current version" which
	 * is separate from the URI identifying each particular version. In this
	 * case, a PUT request on a general URI might result in several other URIs
	 * being defined by the origin server.
	 *
	 * HTTP/1.1 does not define how a PUT method affects the state of an origin
	 * server. PUT requests MUST obey the message transmission requirements set
	 * out in section 8.2.
	 *
	 * Unless otherwise specified for a particular entity-header, the
	 * entity-headers in the PUT request SHOULD be applied to the resource
	 * created or modified by the PUT.
	 *
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.6
	 */
	const METHOD_PUT = 'PUT';
	/**
	 * The DELETE method requests that the origin server delete the resource
	 * identified by the Request-URI. This method MAY be overridden by human
	 * intervention (or other means) on the origin server. The client cannot be
	 * guaranteed that the operation has been carried out, even if the status
	 * code returned from the origin server indicates that the action has been
	 * completed successfully. However, the server SHOULD NOT indicate success
	 * unless, at the time the response is given, it intends to delete the
	 * resource or move it to an inaccessible location.
	 * 
	 * A successful response SHOULD be 200 (OK) if the response includes an
	 * entity describing the status, 202 (Accepted) if the action has not yet
	 * been enacted, or 204 (No Content) if the action has been enacted but the
	 * response does not include an entity.
	 * 
	 * If the request passes through a cache and the Request-URI identifies one
	 * or more currently cached entities, those entries SHOULD be treated as
	 * stale. Responses to this method are not cacheable.
	 * 
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.7
	 */
	const METHOD_DELETE = 'DELETE';
	/**
	 * The TRACE method is used to invoke a remote, application-layer loop- back
	 * of the request message. The final recipient of the request SHOULD reflect
	 * the message received back to the client as the entity-body of a 200 (OK)
	 * response. The final recipient is either the origin server or the first
	 * proxy or gateway to receive a Max-Forwards value of zero (0) in the
	 * request (see section 14.31). A TRACE request MUST NOT include an entity.
	 *
	 * TRACE allows the client to see what is being received at the other end of
	 * the request chain and use that data for testing or diagnostic
	 * information. The value of the Via header field (section 14.45) is of
	 * particular interest, since it acts as a trace of the request chain. Use
	 * of the Max-Forwards header field allows the client to limit the length of
	 * the request chain, which is useful for testing a chain of proxies
	 * forwarding messages in an infinite loop.
	 *
	 * If the request is valid, the response SHOULD contain the entire request
	 * message in the entity-body, with a Content-Type of "message/http".
	 * Responses to this method MUST NOT be cached.
	 *
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.8
	 */
	const METHOD_TRACE = 'TRACE';
	/**
	 * This specification reserves the method name CONNECT for use with a proxy
	 * that can dynamically switch to being a tunnel (e.g. SSL tunneling [44]).
	 * 
	 * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.9
	 */
	const METHOD_CONNECT = 'CONNECT';

	protected $method;

	public function __construct($method = HTTPMethod::METHOD_GET) {
		$this->setMethod($method);
	}

	public function setMethod($method) {
		if (!\is_string($method)) {
			throw new \PHP\Lang\TypeError($method, 'string');
		}
		if (!\preg_match('/^[A-Za-z]+$/', $method)) {
			throw new \PHP\Lang\ValueError($method, 'valid method name');
		}
		$this->method = $method;
	}

	public function getMethod() {
		return $this->method;
	}

	public function __toString() {
		return $this->getMethod();
	}
}