<?php
namespace Tests;

use Hexlet\Code\exceptions\UnsupportedFormatTypeException;
use PHPUnit\Framework\TestCase;
use function Config\getParams;
use function GenDiff\Configs\getContentFormat;
use function GenDiff\Configs\getParam;

class ConfigsTest extends TestCase
{
    private \Closure $stub;

    public function setUp(): void
    {
        $this->stub = static fn() => [
            'parser' => [
                'list' => ['yaml','json'],
            'default' => 'json'
            ],
            'formatter' => ['list' => [
                'stylish','json'
            ],
            'default' => 'stylish'
            ],
        ];

        $this->stub = \Closure::fromCallable($this->stub);
    }

    public function testGetParamDefault(): void
    {
         $parser = getParam('parser', 'test', $this->stub);
         $this->assertEquals('json', $parser);

         $formatter = getParam('formatter', 'test', $this->stub);
         $this->assertEquals('stylish', $formatter);
    }

    public function testGetParam(): void
    {
        $parser = getParam('parser', 'yaml', $this->stub);
        $this->assertEquals('yaml', $parser);

        $formatter = getParam('formatter', 'json', $this->stub);
        $this->assertEquals('json', $formatter);
    }

    public function testIsConfigsRight(): void
    {
        $handler = $this->stub;
        $actualParams = getParams()();
        $expectedParams = $handler();
        $this->assertSame($expectedParams, $actualParams);
    }

    public function testGetContentFormat(): void
    {
        $this->expectException(UnsupportedFormatTypeException::class);
        getContentFormat('text/html');

        $format = getContentFormat('text/yaml');
        $this->assertEquals('yaml', $format);
    }
}
