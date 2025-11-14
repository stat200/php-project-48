<?php

namespace Hexlet\Code\exceptions;

final class AggregateValidationException extends \RuntimeException
{
    public function __construct(private readonly array $errors)
    {
        parent::__construct('Validation failed: ' . count($errors) . ' errors');
    }
    public function getErrors(): array
    {
        return $this->errors;
    }
    public function getErrorsAsString(): string
    {
        return implode("\n", $this->errors);
    }
}
