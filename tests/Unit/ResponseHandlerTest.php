<?php

namespace BeedooTest\Unit;

use Beedoo\Exceptions\InvalidJsonException;
use Beedoo\ResponseHandler;
use PHPUnit\Framework\TestCase;

class ResponseHandlerTest extends TestCase
{
    /** @test */
    public function returnTypeOnSuccess()
    {
        $handler = new ResponseHandler();

        $response = $handler->success('{"foo": "bar"}');

        $this->assertInstanceOf(\stdClass::class, $response);
    }

    /** @test */
    public function returnUsage()
    {
        $response = ResponseHandler::success('{"foo": "bar"}');

        $this->assertObjectHasAttribute('foo', $response);
        $this->assertEquals('bar', $response->foo);
    }

    /** @test */
    public function returnListOfObjects()
    {
        $response = ResponseHandler::success('[{"foo": "bar"},{"bar": "baz"}]');

        $this->assertIsArray($response, 'The list must be an array');
        $this->assertObjectHasAttribute('foo', $response[0], 'The first index must be an object');
        $this->assertEquals('bar', $response[0]->foo);
        $this->assertObjectHasAttribute('bar', $response[1], 'The second index must be an object');
        $this->assertEquals('baz', $response[1]->bar);
    }

    /**
     * @test
     */
    public function unparseablePayload()
    {
        $this->expectException(InvalidJsonException::class);

        ResponseHandler::success('{"foo": "bar"');
    }
}