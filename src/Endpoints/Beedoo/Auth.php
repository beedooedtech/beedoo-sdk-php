<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Auth extends Endpoint
{
    public function login(array $payload)
    {
        $response = $this->client->request(
            self::POST,
            Routes::auth()->base(),
            ['json' => $payload]
        );

        return $response;
    }
}
