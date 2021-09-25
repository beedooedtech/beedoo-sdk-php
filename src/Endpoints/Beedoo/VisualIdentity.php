<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class VisualIdentity extends Endpoint
{
    public function get(array $payload = null)
    {
        $response = $this->client->request(
            self::GET,
            Routes::visualIdentity()->base(),
            ['query' => $payload]
        );

        return $response->data;
    }
}
