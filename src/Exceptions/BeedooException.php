<?php

namespace Beedoo\Exceptions;

final class BeedooException extends \Exception
{
    /**
     * @var srting
     */
    private $errorType;

    public function __construct(int $code, string $errorType, string $message = null)
    {
        $this->code = $code;
        $this->errorType = $errorType;

        parent::__construct($message, $code);
    }

    /**
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->code;
    }
}
