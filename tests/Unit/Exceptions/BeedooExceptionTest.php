<?php

namespace BeedooTest\Unit\Exceptions;

use Beedoo\Exceptions\BeedooException;
use PHPUnit\Framework\TestCase;

final class PagarMeExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function buildExceptionMessage()
    {
        $exception = new BeedooException(
            400,
            'errorTypeTest',
            'value must be array'
        );

        $expectedCode = 400;
        $expectedErrorType = 'errorTypeTest';
        $expectedMessage = 'value must be array';

        $this->assertEquals($expectedCode, $exception->getStatusCode());
        $this->assertEquals($expectedErrorType, $exception->getErrorType());
        $this->assertEquals($expectedMessage, $exception->getMessage());
    }
}