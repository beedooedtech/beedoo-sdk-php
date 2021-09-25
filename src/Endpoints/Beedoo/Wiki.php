<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Wiki extends Endpoint
{
    public function get(array $payload)
    {
        $response = $this->client->request(
            self::GET,
            Routes::wiki()->base(),
            ["query" => $payload]
        );

        return $response->data;
    }

    public function isReadUpdate(array $payload)
    {
        return $this->client->request(
            self::PUT,
            Routes::wiki()->saveArticleRead(),
            ['json' => $payload]
        );
    }
}
