<?php

namespace Tests\Factories;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\exceptions\UnsupportedParserTypeException;

use function Gendiff\Factories\getParser;

class ParserFactoryTest extends TestCase
{
    public function testCreateParser(): void
    {
        $parser = getParser('json');
        $this->assertInstanceOf(\Closure::class, $parser);
    }

    public function testCreateParserThrowsExceptionForUnsupportedType(): void
    {
        $this->expectException(UnsupportedParserTypeException::class);
        $this->expectExceptionMessage('Unsupported parser type');

        getParser('invalid-parser');
    }
}
