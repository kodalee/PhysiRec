<?php

namespace Physler\GoogleApi\Auth\Client\OAuth2;

use Physler\GoogleApi\Auth\Client\OAuth2\Scopes\ScopeBuilder;
use Stringable;

use function PHPSTORM_META\type;

class OAuth2 implements Stringable {
    public $target_endpoint = "https://accounts.google.com/o/oauth2/v2/auth";
    public $client_id;
    public $redirect_uri;
    public $scope;
    public $response_type = "code";

    public function __construct() {/** Nothing needs to be constructed... */}
    public static function CreateUrl() { return new OAuth2(); }

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