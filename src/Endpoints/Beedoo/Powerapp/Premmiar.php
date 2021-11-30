<?php

namespace Beedoo\Endpoints\Beedoo\Powerapp;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Premmiar extends Endpoint
{
    public function get()
    {
        $response = $this->client->request(
            self::GET,
            Routes::powerapp()->premmiar()
        );

        return $response->data;
    }
}
