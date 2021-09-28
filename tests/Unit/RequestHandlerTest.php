<?php

namespace BeedooTest\Unit;

use Beedoo\RequestHandler;
use PHPUnit\Framework\TestCase;

class RequestHandlerTest extends TestCase
{
    /** @test */
    public function bindApiKey()
    {
        $this->assertEquals(
            ['query' => ['api_token' => 'foo']],
            RequestHandler::bindApiKeyToQueryString([], 'foo')
        );
    }
}