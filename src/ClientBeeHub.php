<?php

namespace Beedoo;

use Beedoo\Contracts\BeeHubAuth;
use Beedoo\Endpoints\BeeHub\Wiki;
use Beedoo\Endpoints\BeeHub\AccessToken;

class ClientBeeHub extends Client implements BeeHubAuth
{
    /** @var \Beedoo\Endpoints\BeeHub\AccessToken */
    private $accessToken;

     /** @var \Beedoo\Endpoints\BeeHub\Wiki */
    private $wiki;

    /**
     * @param string $apiKey
     * @param string $baseUrl
     * @param array $options
     */
    public function __construct(string $apiKey, string $baseUrl = "", array $options = [])
    {
        $this->apiKey = $apiKey;

        $this->accessToken = new AccessToken($this);
        $this->wiki = new Wiki($this);

        $options = $this->buildAuthorizationHeader($options);

        parent::__construct($baseUrl, $options);
    }

    /**
     * @param array $options
     *
     * @return array
     */
    public function buildAuthorizationHeader(array $options = []): array
    {
        $options['headers']['Authorization'] = self::AUTH_MODE . " " . $this->apiKey;

        return $options;
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
    public function wiki()
    {
        return $this->wiki;
    }
}
