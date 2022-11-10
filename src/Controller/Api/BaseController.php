<?php

namespace Physler\Controller\Api;

class BaseController {
    private $prematureHeaders = [];

    /**
     * Magic calling method
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments) {
        $this->setStatus(404);
        $this->outputJson([
            "error" => ["code" => 404, "message" => "Resource not found."]
        ]);
    }

    /**
     * Add headers to the output prematurely
     *
     * @param array|string $headers Headers in array (many) or string (single)
     * @return void
     */
    protected function appendHeaders($headers) {
        if (!is_string($headers) && !is_array($headers)) {
            return;
        }

        is_string($headers) 
        /* is a string: */? array_push($this->prematureHeaders, $headers)
        /* is an array: */: array_merge($this->prematureHeaders, $headers);

        return;
    } 

    /**
     * Send an output to the request user.
     * @param mixed $data
     * @param array<string> $headers
     */
    protected function output($data, $headers = []) {
        header_remove('Set-Cookie');
        $headers = array_merge($headers, $this->prematureHeaders);

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

    protected function getMethod() {
        return strtoupper($_SERVER["REQUEST_METHOD"]);
    }

    protected function getQuery() {
        $query = [];
        parse_str($_SERVER["QUERY_STRING"], $query);
        return $query;
    }
    
    public function getSegments() {
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $uri = explode('/', $uri);

        return $uri;
    }

    public function InitAction() {
        $segments = $this->getSegments();
        $target = (ISSET($segments[3]) ? $segments[3] : "");
        $this->{ ( ISSET($target) && !EMPTY($target) ) ? str_replace("_", "", $target) : "_main" }();
    }
}