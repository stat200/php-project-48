<?php

namespace Tests\Factories;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\exceptions\UnsupportedFormatterTypeException;

use function GenDiff\Factories\getFormatter;

class FormatterFactoryTest extends TestCase
{
    public function testCreateFormatter(): void
    {
        $formatter = getFormatter('stylish');
        $this->assertInstanceOf(\Closure::class, $formatter);
    }

    public function testCreateFormatterThrowsExceptionForUnsupportedType(): void
    {
        $this->expectException(UnsupportedFormatterTypeException::class);
        $this->expectExceptionMessage('Unsupported formatter type');

        getFormatter('invalid-format');
    }
}
