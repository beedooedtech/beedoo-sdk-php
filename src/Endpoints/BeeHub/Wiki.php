<?php

namespace Beedoo\Endpoints\BeeHub;

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
            Routes::beehubWiki()->base(),
            ["query" => $payload]
        );

        return $response->data;
    }
}
