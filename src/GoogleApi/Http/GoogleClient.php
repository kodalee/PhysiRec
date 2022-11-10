<?php

namespace Physler\GoogleApi\Http;

use Physler\Config;
use Physler\Http\BaseClient;

enum BaseUri {
    const GOOGLEAPIS = "https://www.googleapis.com";
}

class GoogleClient extends BaseClient {
    public function __construct($options = []) {
        parent::__construct($options);
    }

    public function ExchangeTokens($callback_token) {
        $connection = $this->send("POST", "https://oauth2.googleapis.com/token", [
            "Content-Type: application/x-www-form-urlencoded",
            "User-Agent: Physler.GoogleApi.Http.GoogleClient"
        ], http_build_query([
            CLIENT_ID => Config::GA_CLIENT_ID,
            CLIENT_SECRET => Config::GA_CLIENT_SECRET,
            REDIRECT_URI => 'https://'.$_SERVER['HTTP_HOST']."/api.php/gauth/callback",

            'code' => $callback_token,
            'grant_type' => "authorization_code"
        ]));

        return new ConnectedGoogleClient($connection);
    }
}