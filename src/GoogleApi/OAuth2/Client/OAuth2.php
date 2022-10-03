<?php

namespace Physler\GoogleApi\OAuth2\Client;

use Physler\GoogleApi\OAuth2\Client\OAuth2Url;
use Physler\GoogleApi\OAuth2\Client\Scopes\ScopeBuilder;
use Stringable;

class OAuth2 {
    public static function CreateUrl($arguments) {
        return new OAuth2Url($arguments);
    }
}