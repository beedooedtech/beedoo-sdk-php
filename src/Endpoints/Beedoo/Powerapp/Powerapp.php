<?php

namespace Beedoo\Endpoints\Beedoo\Powerapp;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Powerapp extends Endpoint
{
    public function get(array $payload = [])
    {   
        $response = $this->client->request(
            self::GET,
            Routes::powerapp()->base(),
            ["query" => $payload]
        );

        return $response->data;
    }

    public function premmiar()
    {
        return new Premmiar($this->client);
    }
}
