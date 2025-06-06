<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function Differentiator\genDiff;
use function Differentiator\getContents;

class GendiffTest extends TestCase
{
    private string $expected;

    protected function setUp(): void
    {
        $this->expected = '{
        "- follow":false,
        "host":"hexlet.io",
        "- proxy":"123.234.53.22",
        "- timeout":50,
        "+ timeout":20,
        "+ verbose":true
        }';
    }

    /**
     * @throws \JsonException
     */
    public function testGendiffJsonFormat(): void
    {
        $pathFileJson1 = 'tests/fixtures/file1.json';
        $pathFileJson2 = 'tests/fixtures/file2.json';
        $result = genDiff($pathFileJson1, $pathFileJson2);
        $this->assertJsonStringEqualsJsonString($this->expected, $result);
    }

    /**
     * @throws \Exception
     */
    public function testGendiffYamlFormat(): void
    {
        $pathFileYaml1 = 'tests/fixtures/file1.yaml';
        $pathFileYaml2 = 'tests/fixtures/file2.yaml';
        $result = genDiff($pathFileYaml1, $pathFileYaml2);
        $this->assertJsonStringEqualsJsonString($this->expected, $result);
    }

    public function testGetContentsIsArray(): void
    {
        $expected = [
          ['host' => "hexlet.io",
              'timeout' => 50,
              'proxy' => "123.234.53.22",
              'follow' => false
          ],
          ['timeout' => 20,
              'verbose' => true,
              'host' => "hexlet.io"
          ],
        ];
        $pathFileJson1 = 'tests/fixtures/file1.json';
        $pathFileJson2 = 'tests/fixtures/file2.json';
        $result = getContents('json', $pathFileJson1, $pathFileJson2);
        $this->assertEquals($result, $expected);
    }
}
