<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Team extends Endpoint
{
    public function getAvatar()
    {
        $response = $this->client->request(
            self::GET,
            Routes::team()->avatar()
        );

        return $response->data;
    }
}
