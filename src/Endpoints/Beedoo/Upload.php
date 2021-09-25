<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Upload extends Endpoint
{
    public function getUrl(array $payload)
    {
        $response = $this->client->request(
            self::GET,
            Routes::upload()->url(),
            ['query' => $payload]
        );

        return $response->data;
    }
}
