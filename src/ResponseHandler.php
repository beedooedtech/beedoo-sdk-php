<?php

namespace Beedoo;

use GuzzleHttp\Exception\ClientException;
use Beedoo\Exceptions\BeedooException;
use Beedoo\Exceptions\InvalidJsonException;

class ResponseHandler
{
    /**
     * @param string $payload
     *
     * @throws \Beedoo\Exceptions\InvalidJsonException
     * @return \ArrayObject
     */
    public static function success($payload)
    {
        return self::toJson($payload);
    }

    /**
     * @param ClientException $originalException
     *
     * @throws BeedooException
     * @return void
     */
    public static function failure(\Exception $originalException)
    {
        throw self::parseException($originalException);
    }

    /**
     * @param ClientException $guzzleException
     *
     * @return BeedooException|ClientException
     */
    private static function parseException(ClientException $guzzleException)
    {
        $response = $guzzleException->getResponse();
        $code = $response->getStatusCode();

        if (is_null($response)) {
            return $guzzleException;
        }

        $body = $response->getBody()->getContents();

        try {
            $jsonError = self::toJson($body);
        } catch (InvalidJsonException $invalidJson) {
            return $guzzleException;
        }

        $jsonError->message = property_exists($jsonError, 'message') ? $jsonError->message : null;
        $jsonError->error = property_exists($jsonError, 'error') ? $jsonError->error : "";

        return new BeedooException(
            $code,
            $jsonError->error,
            $jsonError->message
        );
    }

    /**
     * @param string $json
     * @return \ArrayObject
     */
    private static function toJson($json)
    {
        $result = json_decode($json);

        if (json_last_error() != \JSON_ERROR_NONE) {
            throw new InvalidJsonException(json_last_error_msg());
        }

        return $result;
    }
}
