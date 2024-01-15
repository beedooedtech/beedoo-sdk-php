<?php

namespace Beedoo;

use Beedoo\Contracts\BasesUrl;
use Beedoo\Contracts\Headers;
use Beedoo\Contracts\Version;
use Beedoo\RequestHandler;
use Beedoo\ResponseHandler;
use GuzzleHttp\Exception\ClientException as ClientException;
use Beedoo\Exceptions\InvalidJsonException;
use GuzzleHttp\Client as GuzzleHttpClient;


abstract class Client implements Version, BasesUrl, Headers
{
    /** @var \GuzzleHttp\Client */
    protected $http;

    /** @var string */
    private $baseUrlDefault;

    /** @var string */
    protected $apiKey;

    /**
     * @param string $baseUrl
     * @param array $options
     */
    public function __construct(string $baseUrl = "", array $options = [])
    {
        $this->defineBaseUrl($baseUrl);

        $options = $this->buildHeaders($options);

        $this->http = new GuzzleHttpClient($options);
    }

    /**
     * @param mixed $method
     * @param mixed $uri
     * @param array $options
     */
    public function request($method, $uri, $options = [])
    {
        try {
            $response = $this->http->request(
                $method,
                $uri,
                RequestHandler::bindApiKeyToQueryString(
                    $options,
                    $this->apiKey
                )
            );

            return ResponseHandler::success((string)$response->getBody());
        } catch (InvalidJsonException $exception) {
            throw $exception;
        } catch (ClientException $exception) {
            ResponseHandler::failure($exception);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function buildHeaders(array $options = [])
    {
        $options['base_uri'] = $this->baseUrlDefault;

        $userAgent = isset($options['headers']['User-Agent']) ?
            $options['headers']['User-Agent'] :
            '';

        $options['headers']['User-Agent'] = $this->addUserAgentHeaders($userAgent);
        $options['headers']['X-Beedoo-User-Agent'] = $this->addUserAgentHeaders($userAgent);

        return $options;
    }

    /**
     * @param string $customUserAgent
     *
     * @return string
     */
    protected function addUserAgentHeaders($customUserAgent = '')
    {
        return $this->buildUserAgent($customUserAgent);
    }

    /**
     * @param string $customUserAgent
     *
     * @return string
     */
    private function buildUserAgent($customUserAgent = '')
    {
        return trim(sprintf(
            '%s beedoo-sdk-php/%s php/%s',
            $customUserAgent,
            self::VERSION,
            phpversion()
        ));
    }

    /**
     * @param string $baseUrl
     *
     * @return void
     */
    public function defineBaseUrl(string $baseUrl): void
    {
        $this->baseUrlDefault = $baseUrl;
    }
}
