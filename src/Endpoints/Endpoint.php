<?php

namespace Beedoo\Endpoints;

use Beedoo\Client;

abstract class Endpoint
{
    /**
     * @var string
     */
    const POST = 'POST';

    /**
     * @var string
     */
    const GET = 'GET';

    /**
     * @var string
     */
    const PUT = 'PUT';

    /**
     * @var string
     */
    const DELETE = 'DELETE';

    /**
     * @var \Beedoo\Client
     */
    protected $client;

    /**
     * @param \Beedoo\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
