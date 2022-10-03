<?php

namespace Phylser\Controller\Api;

class BaseController {
    /**
     * Magic calling method
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments) {
        $this->outputJson([
            "error" => ["code" => 404, "message" => "Resource not found."]
        ]);
    }

    /**
     * Send an output to the request user.
     * @param mixed $data
     * @param array<string> $headers
     */
    protected function output($data, $headers = []) {
        header_remove('Set-Cookie');

        if ( IS_ARRAY($headers) AND COUNT($headers) ) {
            foreach ($headers as $header) {
                header($header);
            }
        }

        echo $data;
        die;
    }

    protected function setStatus($code) {
        http_response_code($code);
    }

    protected function outputJson($data, $headers = []) {
        array_push($headers, "Content-Type: application/json");
        $this->output(json_encode($data, JSON_PRETTY_PRINT), $headers);
    }

    protected function getRequestMethod() {
        return strtoupper($_SERVER["REQUEST_METHOD"]);
    }

    protected function getQueryStringParams() {
        $query = [];
        parse_str($_SERVER["QUERY_STRING"], $query);
        return $query;
    }
    
    protected function getUriSegments() {
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $uri = explode('/', $uri);

        return $uri;
    }

    public function InitAction() {
        $segments = $this->getUriSegments();
        $target = $segments[3];
        $this->{$target}();
    }
}