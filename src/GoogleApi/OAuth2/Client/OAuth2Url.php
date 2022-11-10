<?php 

namespace Physler\GoogleApi\OAuth2\Client;

use Physler\Config;
use Physler\GoogleApi\OAuth2\Client\OAuth2;

class OAuth2Url extends OAuth2 {
    public $target_endpoint = "https://accounts.google.com/o/oauth2/v2/auth";
    public $client_id;
    public $redirect_uri;
    public $scope;
    public $response_type = "code";

    public function __construct($options) {
        $this->client_id = Config::GA_CLIENT_ID;
        $this->redirect_uri = $options["redirect_uri"];
        $this->scope = $options["scope"];
    }

    public function SetClientId($client_id) {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * Set scope to a specified scope.
     * @return \Physler\GoogleApi\Auth\Client\OAuth2\OAuth2
     */
    public function SetScopes($scopeBuilder) {
        $this->scope = $scopeBuilder;
        return $this;
    }

    public function SetRedirectUri($url) {
        $this->redirect_uri = urlencode($url);
        return $this;
    }

    /** 
     * client_id,
     * redirect_uri,
     * scope,
     * response_type
     */
    public function __toString() {
        return "{$this->target_endpoint}?client_id={$this->client_id}&redirect_uri={$this->redirect_uri}&scope={$this->scope}&response_type={$this->response_type}";
    }
}