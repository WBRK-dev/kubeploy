<?php

namespace App\Exceptions;

use Exception;

class InvalidResourceTypeException extends Exception
{
    public function __construct(
        string $expectedType,
        string $gottenType,
    ) {
        parent::__construct(
            "Expected resource type \"$expectedType\", but gotten \"$gottenType\"",
        );
    }
}
