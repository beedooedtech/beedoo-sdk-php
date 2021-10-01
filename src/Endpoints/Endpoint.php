<?php

namespace Beedoo\Endpoints;

use Beedoo\Client;

abstract class Endpoint
{
    const POST = 'POST';
    const GET = 'GET';
    const PUT = 'PUT';
    const DELETE = 'DELETE';

    /** @var \Beedoo\Client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
