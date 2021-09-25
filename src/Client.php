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
    protected GuzzleHttpClient $http;
    
    private string $baseUrlDefault = 'https://api.beedoo.io/';
    
    protected string $apiKey;

    /**
     * @param string $server
     * @param array $options
     */
    public function __construct(string $server = "", array $options = [])
    {
        $this->defineBaseUrl($server);

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
    private function buildHeaders(array $options = []): array
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
    private function buildUserAgent($customUserAgent = ''): string
    {
        return trim(sprintf(
            '%s beedoo-sdk-php/%s php/%s',
            $customUserAgent,
            self::VERSION,
            phpversion()
        ));
    }

    /**
     * @param string $key
     * 
     * @return void
     */
    public function defineBaseUrl(string $key): void
    {
        if (array_key_exists($key, self::BASES_URL)) {
            $this->baseUrlDefault = self::BASES_URL[$key];
        }
    }
}
