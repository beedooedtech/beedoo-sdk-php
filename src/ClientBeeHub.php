<?php

namespace Beedoo;

use Beedoo\Contracts\BeeHubAuth;
use Beedoo\Endpoints\BeeHub\Wiki;
use Beedoo\Endpoints\BeeHub\AccessToken;

class ClientBeeHub extends Client implements BeeHubAuth
{
    private AccessToken $accessToken;
    private Wiki $wiki;

    /**
     * @param string $apiKey
     * @param string $server
     * @param array $options
     */
    public function __construct(string $apiKey, string $server = "", array $options = [])
    {
        $this->apiKey = $apiKey;

        $this->accessToken = new AccessToken($this);
        $this->wiki = new Wiki($this);

        $options = $this->buildAuthorizationHeader($options);

        parent::__construct($server, $options);
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
     * @return AccessToken
     */
    public function accessToken(): AccessToken
    {
        return $this->accessToken;
    }

    /**
     * @return Wiki
     */
    public function wiki(): Wiki
    {
        return $this->wiki;
    }
}
