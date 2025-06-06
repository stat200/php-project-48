<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Exception\ParseException;

use function Gendiff\Parsers\getParser;
use function Gendiff\Parsers\parsers;

class ParsersTest extends TestCase
{
    public function testParseJsonException(): void
    {
        $this->expectException(\JsonException::class);
        getParser('json')('...');
    }
    public function testParseYamlException(): void
    {
        $this->expectException(ParseException::class);
        getParser('yaml')("\xB1\x31");
    }
}
