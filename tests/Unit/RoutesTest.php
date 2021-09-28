<?php

namespace BeedooTest\Unit;

use Beedoo\Routes;
use PHPUnit\Framework\TestCase;

class RoutesTest extends TestCase
{
    /** @test */
    public function accessTokenRoutes()
    {
        $routes = Routes::accessToken();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
    }

    /** @test */
    public function beehubWikiRoutes()
    {
        $routes = Routes::beehubWiki();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
    }

    /** @test */
    public function groupsRoutes()
    {
        $routes = Routes::groups();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
    }

    /** @test */
    public function wikiRoutes()
    {
        $routes = Routes::wiki();

        $this->assertObjectHasAttribute('isReadArticle', $routes);
        $this->assertIsCallable($routes->isReadArticle);

        $this->assertObjectHasAttribute('saveArticleRead', $routes);
        $this->assertIsCallable($routes->saveArticleRead);
    }

    /** @test */
    public function teamRoutes()
    {
        $routes = Routes::team();

        $this->assertObjectHasAttribute('avatar', $routes);
        $this->assertIsCallable($routes->avatar);
    }

    /** @test */
    public function uploadRoutes()
    {
        $routes = Routes::upload();

        $this->assertObjectHasAttribute('url', $routes);
        $this->assertIsCallable($routes->url);
    }

    /** @test */
    public function visualIdentityRoutes()
    {
        $routes = Routes::visualIdentity();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
    }

    /** @test */
    public function userRoutes()
    {
        $routes = Routes::user();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);

        $this->assertObjectHasAttribute('details', $routes);
        $this->assertIsCallable($routes->details);
    }

    /** @test */
    public function authRoutes()
    {
        $routes = Routes::auth();

        $this->assertObjectHasAttribute('base', $routes);
        $this->assertIsCallable($routes->base);
    }
}