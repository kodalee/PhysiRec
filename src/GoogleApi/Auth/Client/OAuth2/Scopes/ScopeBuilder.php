<?php

namespace Physler\GoogleApi\Auth\Client\OAuth2\Scopes;

use Stringable;

const API_URL = "https://www.googleapis.com";

class ScopeBuilder implements Stringable {
    private $scopes = [];

    public function __construct($endpoints) {
        $this->scopes = $endpoints;
    }

    public function Add($endpoint) {

        array_push($this->scopes, $endpoint);
    }

    public function __toString() {
        $scopes = [];
        for ($i=0; $i < COUNT( $this->scopes ); $i++) { 
            array_push($scopes, urlencode(API_URL . $this->scopes[$i]),);
        }
        return implode("+", $scopes);
    }
}