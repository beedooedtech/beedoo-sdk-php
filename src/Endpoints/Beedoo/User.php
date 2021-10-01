<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;
use Beedoo\Exceptions\BeedooException;

class User extends Endpoint
{
    public function get(array $payload)
    {
        $response = $this->client->request(
            self::GET,
            Routes::user()->base(),
            ["query" => $payload]
        );

        return $response->data;
    }

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
        $identity = array_key_exists('username', $payload) ? $payload['username'] : null;
        $identity = array_key_exists('id', $payload) ? $payload['id'] : null;

        return $this->client->request(
            self::PUT,
            Routes::user()->details($identity),
            ['json' => $payload]
        );
    }

    public function updateOrCreate(array $payload)
    {
        try {
            return $this->update($payload);
        } catch (BeedooException $e) {
            if ($e->getErrorType() === "doesNotUser") {
                return $this->create($payload);
            }
    
            return new BeedooException(
                $e->getStatusCode(),
                $e->getErrorType(),
                $e->getMessage()
            );
        }
    }
}
