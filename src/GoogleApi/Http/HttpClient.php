<?php

namespace Physler\GoogleApi\Http;

enum BaseUri {
    const GOOGLEAPIS = "https://www.googleapis.com/";
}

class HttpClient {
    public static function InitClient($base_uri) {
        return new \GuzzleHttp\Client([ "base_uri" => $base_uri ]);
    }
}