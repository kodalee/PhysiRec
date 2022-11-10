<?php

namespace Physler\GoogleApi\Http;

use Physler\GoogleApi\Http\GoogleClient;

class ConnectedGoogleClient extends GoogleClient {
    protected $access_token = null;
    protected $expires_in = 0;
    protected $refresh_token = null;
    protected $scope = null;
    protected $token_type = null;

    public function __construct($connectionData, $options = []) {
        $this->access_token = $connectionData->access_token;
        $this->expires_in = $connectionData->expires_in;
        $this->scope = $connectionData->scope;
        $this->token_type = $connectionData->token_type;
        $this->id_token = $connectionData->id_token;
        parent::__construct($options);
    }

    /**
     * Get user info.
     *
     * @return object
     */
    public function GetUserInfo() {
        return $this->send("GET", "https://www.googleapis.com/oauth2/v2/userinfo", [
            "Authorization: Bearer {$this->access_token}",
            "User-Agent: Physler.GoogleApi.Http.ConnectedGoogleClient"
        ]);
    }
}