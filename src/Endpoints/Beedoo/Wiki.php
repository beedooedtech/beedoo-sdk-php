<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Wiki extends Endpoint
{
    /**
     * @param array $payload
     *
     * @return \ArrayObject
     */
    public function get(array $payload)
    {
        $response = $this->client->request(
            self::GET,
            Routes::wiki()->base(),
            ["query" => $payload]
        );

        return $response->data;
    }
}
