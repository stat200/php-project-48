<?php

namespace Hexlet\Code\exceptions;

use InvalidArgumentException;

class UnsupportedFormatterTypeException extends InvalidArgumentException
{
    public function __construct(string $type)
    {
        parent::__construct("Unsupported formatter type: {$type}");
    }
}
