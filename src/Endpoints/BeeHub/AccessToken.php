<?php

namespace Beedoo\Endpoints\BeeHub;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class AccessToken extends Endpoint
{
    public function get(array $payload)
    {
        $response = $this->client->request(
            self::GET,
            Routes::accessToken()->base(),
            ["query" => $payload]
        );

        return $response->data[0]->attributes;
    }
}
