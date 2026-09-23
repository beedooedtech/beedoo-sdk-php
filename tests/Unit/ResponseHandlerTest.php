<?php

namespace BeedooTest\Unit;

use Beedoo\Exceptions\BeedooException;
use Beedoo\Exceptions\InvalidJsonException;
use Beedoo\ResponseHandler;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ResponseHandlerTest extends TestCase
{
    private function clientExceptionWithBody(int $code, string $body): ClientException
    {
        return new ClientException(
            'error',
            new Request('GET', '/'),
            new Response($code, [], $body)
        );
    }
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

    /** @test */
    public function failureParsesLegacyFlatShape()
    {
        $exception = $this->clientExceptionWithBody(400, '{"error":"InvalidNameGroup","message":"Group name is nonstandard"}');

        try {
            ResponseHandler::failure($exception);
            $this->fail('Expected BeedooException was not thrown.');
        } catch (BeedooException $e) {
            $this->assertSame('Group name is nonstandard', $e->getMessage());
            $this->assertSame('InvalidNameGroup', $e->getErrorType());
            $this->assertSame(400, $e->getStatusCode());
        }
    }

    /** @test */
    public function failureParsesJsonApiErrorsShape()
    {
        $exception = $this->clientExceptionWithBody(
            400,
            '{"status":"error","errors":[{"status":"400","detail":"Login já cadastrado."}]}'
        );

        try {
            ResponseHandler::failure($exception);
            $this->fail('Expected BeedooException was not thrown.');
        } catch (BeedooException $e) {
            $this->assertSame('Login já cadastrado.', $e->getMessage());
        }
    }

    /** @test */
    public function failureParsesBeeHubFailDataShape()
    {
        // Same shape AuthenticateUserByClientIdController's notFound() sends.
        $exception = $this->clientExceptionWithBody(
            404,
            '{"status":"fail","data":[{"code":"NotFoundError","status":"404","detail":"Not found"}]}'
        );

        try {
            ResponseHandler::failure($exception);
            $this->fail('Expected BeedooException was not thrown.');
        } catch (BeedooException $e) {
            $this->assertSame('Not found', $e->getMessage());
            $this->assertSame('NotFoundError', $e->getErrorType());
        }
    }

    /** @test */
    public function failureHandlesEmptyBodyGracefully()
    {
        $exception = $this->clientExceptionWithBody(404, '{}');

        try {
            ResponseHandler::failure($exception);
            $this->fail('Expected BeedooException was not thrown.');
        } catch (BeedooException $e) {
            $this->assertSame('', $e->getMessage());
            $this->assertSame(404, $e->getStatusCode());
        }
    }
}