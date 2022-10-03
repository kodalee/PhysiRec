<?php

namespace Phylser\Http;

/** Informative HTTP codes */
const HTTP_CONTINUE = 100;
const HTTP_SWITCHING_PROTOCOLS = 101;
const HTTP_EARLY_HINTS = 103;

/** Successful HTTP codes */
const HTTP_OK = 200;
const HTTP_CREATED = 201;
const HTTP_ACCEPTED = 202;
const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
const HTTP_NO_CONTENT = 204;
const HTTP_RESET_CONTENT = 205;
const HTTP_PARTIAL_CONTENT = 206;

/** Redirection HTTP codes */
const HTTP_MULTIPLE_CHOICES = 300;
const HTTP_MOVED_INDEF = 301;
const HTTP_FOUND = 302;
const HTTP_SEE_OTHER = 303;
const HTTP_NOT_MODIFIED = 304;
/** @deprecated */ const HTTP_USE_PROXY = 305;
/** @deprecated */ const HTTP_UNUSED = 306;
const HTTP_REDIR_TEMPORARY = 307;
const HTTP_REDIR_INDEF = 308;

/** Client error HTTP codes */
const HTTP_BAD_REQUEST = 400;
const HTTP_UNAUTHORIZED = 401;
const HTTP_PAYMENT_REQUIRED = 402;
const HTTP_FORBIDDEN = 403;
const HTTP_NOT_FOUND = 404;
const HTTP_METHOD_NOT_ALLOWED = 405;
const HTTP_NOT_ACCEPTABLE = 406;
const HTTP_PROXY_AUTH_REQUIRED = 407;
const HTTP_TIMEOUT = 408;
const HTTP_CONFLICT = 409;
const HTTP_GONE = 410;
const HTTP_LENGTH_REQUIRED = 411;
const HTTP_PRECOND_FAILED = 412;
const HTTP_PAYLOAD_TOO_LARGE = 413;
const HTTP_URI_TOO_LONG = 414;
const HTTP_UNSUPPORTED_MEDIA = 415;
const HTTP_RANGE_NON_SATISFIED = 416;
const HTTP_IM_A_TEAPOT = 418;
/** @experimental */ const HTTP_TOO_EARLY = 425;
const HTTP_UPGRADE_REQUIRED = 426;
const HTTP_PRECOND_REQUIRED = 428;
const HTTP_RATE_LIMIT = 429;
const HTTP_LEGAL_ISSUES = 451;

/** Server error HTTP codes */
const HTTP_SERVER_ERROR = 500;
const HTTP_NOT_IMPLEMENTED = 501;
const HTTP_BAD_GATEWAY = 502;
const HTTP_SERVICE_UNAVAILABLE = 503;
const HTTP_GATEWAY_TIMEOUT = 504;
const HTTP_BAD_HTTP_VERSION = 505;
const HTTP_VARIANT_ALSO_NEGOTIATES = 506;
const HTTP_NOT_EXTENDED = 510;
const HTTP_NETWORK_AUTH_REQUIRED =  511;

class Client {
    public $base_uri = "";

    public function __construct($options) {

    }

    /**
     * @param "GET" $method
     */
    public function request($method) {

    }
}