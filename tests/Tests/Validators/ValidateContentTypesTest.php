<?php

namespace Tests\Validators;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

use function GenDiff\Validators\validateContentTypes;

class ValidateContentTypesTest extends TestCase
{
    public function testUnsupportedExpectedTypeThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported content type');

        validateContentTypes(['application/xml', 'application/xml']);
    }

    public function testUnsupportedActualTypeThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported content type');

        validateContentTypes(['application/json', 'application/xml']);
    }

    public function testMismatchedTypesThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Content-Type mismatch');

        validateContentTypes(['application/json', 'text/plain']);
    }
}
