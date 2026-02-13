<?php

namespace Hexlet\Code\exceptions;

use InvalidArgumentException;

class UnsupportedParserTypeException extends InvalidArgumentException
{
    public function __construct(string $type)
    {
        parent::__construct("Unsupported parser type: {$type}");
    }
}
