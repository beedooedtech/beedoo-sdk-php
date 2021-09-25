<?php

namespace Beedoo\Exceptions;

final class InvalidKeyException extends \Exception
{
    public function __construct($errorMessage, $code = 400)
    {
        parent::__construct($errorMessage, $code);
    }
}
