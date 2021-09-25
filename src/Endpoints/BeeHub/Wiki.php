<?php

namespace Beedoo\Endpoints\BeeHub;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Wiki extends Endpoint
{
    public function get(array $payload): array
    {
        $response = $this->client->request(
            self::GET,
            Routes::beehubWiki()->base(),
            ["query" => $payload]
        );

        return $response->data;
    }
}
