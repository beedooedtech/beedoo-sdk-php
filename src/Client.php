<?php

namespace Beedoo;

use Beedoo\Beedoo;
use Beedoo\Endpoints\Beedoo\Team;
use Beedoo\Endpoints\Beedoo\User;
use Beedoo\Endpoints\Beedoo\Wiki;
use Beedoo\Endpoints\BeeHub\AccessToken;
use Beedoo\Endpoints\BeeHub\Wiki as BeehubWiki;
use Beedoo\RequestHandler;
use Beedoo\ResponseHandler;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException as ClientException;
use Beedoo\Exceptions\InvalidJsonException;

class Client
{
    /**
     * @var string
     */
    const BASE_URI = 'https://hml-api.beedoo.io:4020/';

    /**
     * @var string header used to identify application's requests
     */
    const BEEDOO_USER_AGENT_HEADER = 'X-Beedoo-User-Agent';

    /**
     * @var \GuzzleHttp\Client
     */
    private $http;

    /**
     * @var \Beedoo\Endpoints\BeeHub\AccessToken
     */
    private $accessToken;

    /**
     * @var \Beedoo\Endpoints\BeeHub\Wiki
     */
    private $beehubWiki;

    /**
     * @var \Beedoo\Endpoints\Beedoo\Wiki
     */
    private $wiki;

    /**
     * @var \Beedoo\Endpoints\Beedoo\Team
     */
    private $team;

    /**
     * @var \Beedoo\Endpoints\Beedoo\User
     */
    private $user;

    /**
     * @var string
     */
    private string $apiKey;

    /**
     * @param string $apiKey
     * @param array|null $extras
     */
    public function __construct(string $apiKey, string $authType = "Bearer", array $extras = null)
    {
        $this->apiKey = $apiKey;

        $options = $this->buildHeaders($extras, $authType);

        $this->http = new HttpClient($options);

        $this->accessToken = new AccessToken($this);
        $this->beehubWiki = new BeehubWiki($this);
        $this->wiki = new Wiki($this);
        $this->team = new Team($this);
        $this->user = new User($this);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     *
     * @throws \Beedoo\Exceptions\BeedooException
     * @return \ArrayObject
     *
     * @psalm-suppress InvalidNullableReturnType
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
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Build an user-agent string to be informed on requests
     *
     * @param string $customUserAgent
     *
     * @return string
     */
    private function buildUserAgent($customUserAgent = '')
    {
        return trim(sprintf(
            '%s beedoo-php/%s php/%s',
            $customUserAgent,
            Beedoo::VERSION,
            phpversion()
        ));
    }

    /**
     * Build an headers array to be informed on requests
     *
     * @param array $extras
     *
     * @return array
     */
    private function buildHeaders(array $extras = null, string $authType = "Bearer"): array
    {
        $options = ['base_uri' => self::BASE_URI];

        if (!is_null($extras)) {
            $options = array_merge($options, $extras);
        }

        $options['headers']['Authorization'] = "{$authType} {$this->apiKey}";

        $userAgent = isset($options['headers']['User-Agent']) ?
            $options['headers']['User-Agent'] :
            '';

        $options['headers']['User-Agent'] = $this->addUserAgentHeaders($userAgent);
        $options['headers']['X-Beedoo-User-Agent'] = $this->addUserAgentHeaders($userAgent);

        return $options;
    }

    /**
     * Append new keys (the default and beedoo) related to user-agent
     *
     * @param string $customUserAgent
     * @return string
     */
    private function addUserAgentHeaders($customUserAgent = '')
    {
        return $this->buildUserAgent($customUserAgent);
    }

    /**
     * @return \Beedoo\Endpoints\BeeHub\AccessToken
     */
    public function accessToken()
    {
        return $this->accessToken;
    }

    /**
     * @return \Beedoo\Endpoints\BeeHub\Wiki
     */
    public function beehubWiki()
    {
        return $this->beehubWiki;
    }

    /**
     * @return \Beedoo\Endpoints\Beedoo\Wiki
     */
    public function wiki()
    {
        return $this->wiki;
    }

    /**
     * @return \Beedoo\Endpoints\Beedoo\Team
     */
    public function team()
    {
        return $this->team;
    }

    /**
     * @return \Beedoo\Endpoints\Beedoo\User
     */
    public function user()
    {
        return $this->user;
    }
}
