<?php

namespace Physler\GoogleApi\Auth\Server\OAuth2;

use Phylser\Config;
use Physler\GoogleApi\Http\BaseUri;
use Physler\GoogleApi\Http\HttpClient;

class OAuth2 {
    public static function exchangeForToken($code, $scope) {
        $response = HttpClient::InitClient(BaseUri::GOOGLEAPIS)->request('POST', '/auth/userinfo.email', [
            'form_params' => [
                "code" => $code,
                "scope" => $scope,
                "client_id" => Config::GA_CLIENT_ID,
                "client_secret" => Config::GA_CLIENT_SECRET,
                "grant_type" => "authorization_code"
            ]
        ]);

        var_dump($response);
    }
}