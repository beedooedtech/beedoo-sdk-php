<?php

namespace Beedoo;

use Beedoo\Contracts\BeedooAuth;
use Beedoo\Endpoints\Beedoo\Auth;
use Beedoo\Endpoints\Beedoo\Groups;
use Beedoo\Endpoints\Beedoo\Team;
use Beedoo\Endpoints\Beedoo\Upload;
use Beedoo\Endpoints\Beedoo\User;
use Beedoo\Endpoints\Beedoo\VisualIdentity;
use Beedoo\Endpoints\Beedoo\Wiki;

class ClientBeedoo extends Client implements BeedooAuth
{
    private Groups $groups;
    private Wiki $wiki;
    private Team $team;
    private Upload $upload;
    private VisualIdentity $visualIdentity;
    private User $user;
    private Auth $auth;

    /**
     * @param string $apiKey Your Secret Key
     * @param string $server production = null | homologation = "hml" | development = "dev"
     * @param array $options
     */
    public function __construct(string $apiKey = "", string $server = "", array $options = [])
    {
        $this->apiKey = $apiKey;

        $this->groups = new Groups($this);
        $this->wiki = new Wiki($this);
        $this->team = new Team($this);
        $this->upload = new Upload($this);
        $this->visualIdentity = new VisualIdentity($this);
        $this->user = new User($this);
        $this->auth = new Auth($this);

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
     * @return Auth
     */
    public function auth(): Auth
    {
        return $this->auth;
    }

    /**
     * @return Groups
     */
    public function groups(): Groups
    {
        return $this->groups;
    }

    /**
     * @return Wiki
     */
    public function wiki(): Wiki
    {
        return $this->wiki;
    }

    /**
     * @return Team
     */
    public function team(): Team
    {
        return $this->team;
    }

    /**
     * @return Upload
     */
    public function upload(): Upload
    {
        return $this->upload;
    }

    /**
     * @return VisualIdentity
     */
    public function visualIdentity(): VisualIdentity
    {
        return $this->visualIdentity;
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return $this->user;
    }
}
