<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Groups extends Endpoint
{
    public function get(array $payload = null)
    {
        $response = $this->client->request(
            self::GET,
            Routes::groups()->base(),
            ["query" => $payload]
        );

        return $response->data;
    }

    public function create(array $payload)
    {
        return $this->client->request(
            self::POST,
            Routes::groups()->base(),
            ['json' => $payload]
        );
    }
}
