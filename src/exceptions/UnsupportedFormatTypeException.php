<?php

namespace Hexlet\Code\exceptions;

final class UnsupportedFormatTypeException extends \RuntimeException
{
    public function __construct(
        string $message = 'Unsupported format type',
        int $code = 415,
        ?\Throwable $prev = null
    ) {
        parent::__construct($message, $code, $prev);
    }
}
