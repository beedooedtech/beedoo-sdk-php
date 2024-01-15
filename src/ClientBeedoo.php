<?php

namespace Beedoo;

use Beedoo\Contracts\BeedooAuth;
use Beedoo\Endpoints\Beedoo\Auth;
use Beedoo\Endpoints\Beedoo\Groups;
use Beedoo\Endpoints\Beedoo\Powerapp\Powerapp;
use Beedoo\Endpoints\Beedoo\Team;
use Beedoo\Endpoints\Beedoo\Upload;
use Beedoo\Endpoints\Beedoo\User;
use Beedoo\Endpoints\Beedoo\VisualIdentity;
use Beedoo\Endpoints\Beedoo\Wiki;

class ClientBeedoo extends Client implements BeedooAuth
{
    /** @var \Beedoo\Endpoints\Beedoo\Groups */
    private $groups;

    /** @var \Beedoo\Endpoints\Beedoo\Wiki */
    private $wiki;

    /** @var \Beedoo\Endpoints\Beedoo\Team */
    private $team;

    /** @var \Beedoo\Endpoints\Beedoo\Upload */
    private $upload;

    /** @var \Beedoo\Endpoints\Beedoo\VisualIdentity */
    private $visualIdentity;

    /** @var \Beedoo\Endpoints\Beedoo\User */
    private $user;

    /** @var \Beedoo\Endpoints\Beedoo\Auth */
    private $auth;

    /** @var \Beedoo\Endpoints\Beedoo\Powerapp\Powerapp */
    private $powerapp;

    /**
     * @param string $apiKey Your Secret Key
     * @param string $baseUrl
     * @param array $options
     */
    public function __construct(string $apiKey = "", string $baseUrl = "", array $options = [])
    {
        $this->apiKey = $apiKey;

        $this->groups = new Groups($this);
        $this->wiki = new Wiki($this);
        $this->team = new Team($this);
        $this->upload = new Upload($this);
        $this->visualIdentity = new VisualIdentity($this);
        $this->user = new User($this);
        $this->auth = new Auth($this);
        $this->powerapp = new Powerapp($this);

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
     * @return \Beedoo\Endpoints\Beedoo\Auth
     */
    public function auth()
    {
        return $this->auth;
    }

    /**
     * @return \Beedoo\Endpoints\Beedoo\Groups
     */
    public function groups()
    {
        return $this->groups;
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
     * @return \Beedoo\Endpoints\Beedoo\Upload
     */
    public function upload()
    {
        return $this->upload;
    }

    /**
     * @return \Beedoo\Endpoints\Beedoo\VisualIdentity
     */
    public function visualIdentity()
    {
        return $this->visualIdentity;
    }

    /**
     * @return \Beedoo\Endpoints\Beedoo\User
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @return \Beedoo\Endpoints\Beedoo\Powerapp\Powerapp
     */
    public function powerapp()
    {
        return $this->powerapp;
    }
}
