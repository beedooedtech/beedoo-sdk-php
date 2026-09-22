<?php

namespace Beedoo\Endpoints\Beedoo;

use Beedoo\Routes;
use Beedoo\Endpoints\Endpoint;
use Beedoo\Exceptions\BeedooException;

class User extends Endpoint
{
    public function get(array $payload = [])
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

    /**
     * @param array $payload
     * @param string|null $identityName One of: id|username|login|email|cpf.
     *                                  When provided, $payload must contain that key
     *                                  and it is used to identify the user in the route.
     */
    public function update(array $payload, string $identityName = null)
    {
        $identity = $this->resolveIdentity($payload, $identityName);

        return $this->client->request(
            self::PUT,
            Routes::user()->details($identity, $identityName),
            ['json' => $payload]
        );
    }

    private function resolveIdentity(array $payload, ?string $identityName)
    {
        if ($identityName !== null) {
            if (!array_key_exists($identityName, $payload)) {
                throw new \InvalidArgumentException("Payload must contain '{$identityName}' when identityName is provided.");
            }

            return $payload[$identityName];
        }

        if (array_key_exists('id', $payload)) {
            return $payload['id'];
        }

        if (array_key_exists('username', $payload)) {
            return $payload['username'];
        }

        return 0;
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
