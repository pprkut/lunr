<?php

/**
 * This file contains http return codes.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * HTTP status codes.
 */
class HttpCode
{

    // Informational

    /**
     * The client should continue with its request, or ignore this if the request already completed.
     * @var Integer
     */
    const SHOULD_CONTINUE = 100;

    /**
     * Server understands and is willing to upgrade the protocol used on the current connection.
     * @var Integer
     */
    const SWITCHING_PROTOCOLS = 101;

    /**
     * An interim response used to inform the client that the server has accepted the complete request, but has not yet completed it.
     * @var Integer
     */
    const PROCESSING = 102;

    // Successful

    /**
     * Request has succeeded.
     * @var Integer
     */
    const OK = 200;

    /**
     * Request was fulfilled and new resource was created.
     * @var Integer
     */
    const CREATED = 201;

    /**
     * Request was accepted for processing, but processing has not completed.
     * @var Integer
     */
    const ACCEPTED = 202;

    /**
     * Returned meta-information is not definitive from the origin server, but gathered from local or third-party copy.
     * @var Integer
     */
    const NON_AUTHORITATIVE_INFORMATION = 203;

    /**
     * Request was fulfilled but there is no need to return content.
     * @var Integer
     */
    const NO_CONTENT = 204;

    /**
     * Request was fulfilled and client should reset the source which caused the request.
     * @var Integer
     */
    const RESET_CONTENT = 205;

    /**
     * Request was acted upon and the requested partial content is returned.
     * @var Integer
     */
    const PARTIAL_CONTENT = 206;

    // Redirection

    /**
     * Requested resource corresponds to any one of a set of representations.
     * @var Integer
     */
    const MULTIPLE_CHOICES = 300;

    /**
     * Requested resource moved permanently to a different location.
     * @var Integer
     */
    const MOVED_PERMANENTLY = 301;

    /**
     * Requested resource temporarily moved to a different location, but will return.
     * @var Integer
     */
    const FOUND = 302;

    /**
     * Response of request can be found somewhere else.
     * @var Integer
     */
    const SEE_OTHER = 303;

    /**
     * Requested resource has not been modified.
     * @var Integer
     */
    const NOT_MODIFIED = 304;

    /**
     * Resource must be accessed using provided proxy.
     * @var Integer
     */
    const USE_PROXY = 305;

    /**
     * Requested resource temporarily moved to a different location, but will return.
     * @var Integer
     */
    const TEMPORARY_REDIRECT = 307;

    /**
     * The target resource has been assigned a new permanent URI and any future references to this resource ought to use one of the enclosed URIs.
     * @var Integer
     */
    const PERMANENT_REDIRECT = 308;

    // Client Error

    /**
     * Request could not be understood due to malformed syntax.
     * @var Integer
     */
    const BAD_REQUEST = 400;

    /**
     * The request requires authentication.
     * @var Integer
     */
    const UNAUTHORIZED = 401;

    /**
     * The request requires payment.
     * @var Integer
     */
    const PAYMENT_REQUIRED = 402;

    /**
     * Request understood, but refused to be fulfilled.
     * @var Integer
     */
    const FORBIDDEN = 403;

    /**
     * Requested resource was not found.
     * @var Integer
     */
    const NOT_FOUND = 404;

    /**
     * Requested method is not allowed on resource.
     * @var Integer
     */
    const METHOD_NOT_ALLOWED = 405;

    /**
     * Resource can not return content in client acceptable form.
     * @var Integer
     */
    const NOT_ACCEPTABLE = 406;

    /**
     * Request requires authentication with a proxy first.
     * @var Integer
     */
    const PROXY_AUTHENTICATION_REQUIRED = 407;

    /**
     * Client did not produce request in reasonable timeframe.
     * @var Integer
     */
    const REQUEST_TIMEOUT = 408;

    /**
     * Request could not be completed due to a conflict in the resource.
     * @var Integer
     */
    const CONFLICT = 409;

    /**
     * Requested resource is no longer available and no forwarding address is known.
     * @var Integer
     */
    const GONE = 410;

    /**
     * Request refused without provided Content Length.
     * @var Integer
     */
    const LENGTH_REQUIRED = 411;

    /**
     * Provided precondition from the client failed.
     * @var Integer
     */
    const PRECONDITION_FAILED = 412;

    /**
     * Request too large.
     * @var Integer
     */
    const REQUEST_ENTITY_TOO_LARGE = 413;

    /**
     * Request URI too long.
     * @var Integer
     */
    const REQUEST_URI_TOO_LONG = 414;

    /**
     * Requested resource does not understand request format.
     * @var Integer
     */
    const UNSUPPORTED_MEDIA_TYPE = 415;

    /**
     * Requested partial content could not be served.
     * @var Integer
     */
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;

    /**
     * Client expectation could not be met.
     * @var Integer
     */
    const EXPECTATION_FAILED = 417;

    /**
     * Client attempted to brew coffee with a teapot.
     * @var Integer
     */
    const I_AM_A_TEAPOT = 418;

    /**
     * The request was directed at a server that is not able to produce a response.
     * @var Integer
     */
    const MISDIRECTED_REQUEST = 421;

    /**
     * The server understands the content type of the request entity,
     * and the syntax of the request entity is correct but was unable to process the contained instructions.
     * @var Integer
     */
    const UNPROCESSABLE_ENTITY = 422;

    /**
     * The source or destination resource of a method is locked.
     * @var Integer
     */
    const LOCKED = 423;

    /**
     * The method could not be performed on the resource because the requested action depended on another action and that action failed.
     * @var Integer
     */
    const FAILED_DEPENDENCY = 424;

    /**
     * The server refuses to perform the request using the current protocol
     * but might be willing to do so after the client upgrades to a different protocol.
     * @var Integer
     */
    const UPGRADE_REQUIRED = 426;

    /**
     * The origin server requires the request to be conditional.
     * @var Integer
     */
    const PRECONDITION_REQUIRED = 428;

    /**
     * The user has sent too many requests in a given amount of time ("rate limiting").
     * @var Integer
     */
    const TOO_MANY_REQUESTS = 429;

    /**
     * The server is unwilling to process the request because its header fields are too large.
     * @var Integer
     */
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;

    // Server Error

    /**
     * Unexpected condition occured, preventing successful fulfillment.
     * @var Integer
     */
    const INTERNAL_SERVER_ERROR = 500;

    /**
     * Server does not support functionality required to fulfill the request.
     * @var Integer
     */
    const NOT_IMPLEMENTED = 501;

    /**
     * Server received invalid reply from third-party resource.
     * @var Integer
     */
    const BAD_GATEWAY = 502;

    /**
     * Unable to fulfill request because of temporary overload or maintenance.
     * @var Integer
     */
    const SERVICE_UNAVAILABLE = 503;

    /**
     * Server did not receive reply from third-party resource.
     * @var Integer
     */
    const GATEWAY_TIMEOUT = 504;

    /**
     * Server does not support HTTP version used in the request.
     * @var Integer
     */
    const HTTP_VERSION_NOT_SUPPORTED = 505;

}

?>
