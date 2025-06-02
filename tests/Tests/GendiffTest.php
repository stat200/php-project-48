<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Differentiator\genDiff;

class GendiffTest extends TestCase
{
    private string $pathFile1;
    private string $pathFile2;

    public function setUp(): void
    {
        $this->pathFile1 = 'tests/fixtures/file1.json';
        $this->pathFile2 = 'tests/fixtures/file2.json';
    }

    /**
     * @throws \JsonException
     */
    public function testGendiff(): void
    {
        $expected = '{
        "- follow":false,
        "host":"hexlet.io",
        "- proxy":"123.234.53.22",
        "- timeout":50,
        "+ timeout":20,
        "+ verbose":true
        }';
        $result = genDiff($this->pathFile1, $this->pathFile2);
        $this->assertJsonStringEqualsJsonString($expected, $result);
    }
}
