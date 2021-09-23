<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;

class User extends Endpoint
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
            Routes::user()->base(),
            ["query" => $payload]
        );

        return $response->data;
    }

    /**
     * @param int $userId
     * 
     * @return \ArrayObject
     */
    public function find(int $userId)
    {
        $response = $this->client->request(
            self::GET,
            Routes::user()->details($userId)
        );

        return $response->data;
    }

    public function create(array $payload)
    {
        return $this->client->request(
            self::POST,
            Routes::user()->base(),
            ['json' => $payload]
        );
    }

    public function update(array $payload)
    {
        return $this->client->request(
            self::PUT,
            Routes::user()->details($payload['id']),
            ['json' => $payload]
        );
    }

    public function createOrUpdate(array $payload)
    {
        $user = $this->find($payload['email']);

        if (! $user) {
            return $this->create($payload);
        }

        return $this->update($payload);
    }
}
