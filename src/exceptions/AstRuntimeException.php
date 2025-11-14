<?php

namespace Hexlet\Code\exceptions;

class AstRuntimeException extends \RuntimeException
{
    public function __construct(
        string $message = 'AST format invalid',
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
