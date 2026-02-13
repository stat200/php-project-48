<?php

namespace Tests\Config;

use Hexlet\Code\exceptions\UnsupportedFormatterTypeException;
use PHPUnit\Framework\TestCase;
use Hexlet\Code\exceptions\UnsupportedParserTypeException;
use GenDiff\Configs\ParamType;

use function GenDiff\Configs\getParam;
use function GenDiff\Configs\getParserType;
use function GenDiff\Configs\getFormatterType;
use function GenDiff\Utils\getParserTypeByMime;

class ConfigTest extends TestCase
{
    public function testParserTypes(): void
    {
        $this->assertSame([
            'json' => 'json',
            'yaml' => 'yaml',
            'default' => 'json'
        ], getParserType());
    }

    public function testFormatterTypes(): void
    {
        $this->assertSame([
            'stylish' => 'stylish',
            'plain' => 'plain',
            'default' => 'stylish'
        ], getFormatterType());
    }

    public function testGetExplicitParserType(): void
    {
        $this->assertEquals('json', getParam(ParamType::Parser, 'json'));
    }

    public function testGetExplicitFormatterType(): void
    {
        $this->assertEquals('stylish', getParam(ParamType::Formatter, 'stylish'));
    }

    public function testGetDefaultParserType(): void
    {
        $this->assertEquals('json', getParam(ParamType::Parser, 'json'));
    }

    public function testGetDefaultFormatterType(): void
    {
        $this->assertEquals('stylish', getParam(ParamType::Formatter, 'stylish'));
    }

    public function testGetParserTypeByMimeJson(): void
    {
        $this->assertSame('json', getParserTypeByMime('application/json'));
    }

    public function testGetParserTypeByMimeYaml(): void
    {
        $this->assertSame('yaml', getParserTypeByMime('text/yaml'));
    }

    public function testThrowsExceptionForUnsupportedMime(): void
    {
        $this->expectException(UnsupportedParserTypeException::class);
        getParserTypeByMime('application/xml');
    }

    public function testGetParserTypeDefault(): void
    {
        $this->assertEquals('json', getParam(ParamType::Parser));
    }

    public function testGetFormatterTypeDefault(): void
    {
        $this->assertEquals('stylish', getParam(ParamType::Formatter));
    }

    public function testThrowsExceptionForUnsupportedFormatter(): void
    {
        $this->expectException(UnsupportedFormatterTypeException::class);
        getParam(ParamType::Formatter, '124354');
    }

    public function testThrowsExceptionForUnsupportedParser(): void
    {
        $this->expectException(UnsupportedParserTypeException::class);
        getParam(ParamType::Parser, '124354');
    }
}
