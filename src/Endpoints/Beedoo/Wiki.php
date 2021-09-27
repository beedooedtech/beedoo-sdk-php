<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class Wiki extends Endpoint
{
    public function getIsReadArticle(array $payload)
    {
        $response = $this->client->request(
            self::GET,
            Routes::wiki()->isReadArticle(),
            ["query" => $payload]
        );

        return $response->data;
    }

    public function saveArticleRead(array $payload)
    {
        return $this->client->request(
            self::PUT,
            Routes::wiki()->saveArticleRead(),
            ['json' => $payload]
        );
    }
}
