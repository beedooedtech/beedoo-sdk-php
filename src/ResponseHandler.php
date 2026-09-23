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

        return new BeedooException(
            $code,
            self::extractErrorType($jsonError),
            self::extractErrorMessage($jsonError)
        );
    }

    /**
     * The Core API returns error bodies in more than one shape depending on
     * which endpoint/subsystem answers:
     *   - legacy flat shape:      {"error": "...", "message": "..."}
     *   - JSON:API-ish payload:   {"status": "error", "errors": [{"status": "...", "detail": "..."}]}
     *                             {"status": "fail",  "data":   [{"status": "...", "detail": "..."}]}
     *   - no body at all (e.g. a bare 404) -- $jsonError has none of the above.
     * Try each in order so a message is still surfaced whichever shape the
     * response actually used, instead of silently coming back empty.
     *
     * @param mixed $jsonError
     */
    private static function extractErrorMessage($jsonError): string
    {
        if (property_exists($jsonError, 'message') && $jsonError->message) {
            return $jsonError->message;
        }

        foreach (['errors', 'data'] as $listProperty) {
            if (property_exists($jsonError, $listProperty) && is_array($jsonError->{$listProperty})) {
                $first = $jsonError->{$listProperty}[0] ?? null;
                if ($first !== null && !empty($first->detail)) {
                    return $first->detail;
                }
            }
        }

        // BeedooException's $message is typed `string $message = null` (i.e.
        // implicitly nullable) but PHP's own Exception::__construct() is
        // NOT nullable-typed for $message -- passing null there is a
        // deprecation warning as of PHP 8.1. Never pass null through.
        return "";
    }

    /**
     * @param mixed $jsonError
     */
    private static function extractErrorType($jsonError): string
    {
        if (property_exists($jsonError, 'error') && $jsonError->error) {
            return $jsonError->error;
        }

        foreach (['errors', 'data'] as $listProperty) {
            if (property_exists($jsonError, $listProperty) && is_array($jsonError->{$listProperty})) {
                $first = $jsonError->{$listProperty}[0] ?? null;
                if ($first !== null && !empty($first->code)) {
                    return $first->code;
                }
            }
        }

        return "";
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
