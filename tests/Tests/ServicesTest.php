<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\Services\getContents;
use function GenDiff\Services\getPaths;

class ServicesTest extends TestCase
{
    private \Closure $stub;
    private array $paths;
    public function setUp(): void
    {
        $this->paths = [
            'tests/fixtures/file1Multidimensional.json',
            'tests/fixtures/file2Multidimensional.json'
        ];
        $this->stub = function ($jsonString) {
            return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
        };

        $this->stub = \Closure::fromCallable($this->stub);
    }

    public function testGetContents(): void
    {
        $result = getContents($this->stub, $this->paths);
        $this->assertIsArray($result);
    }

    public function testGetContentsReturnsParsedData(): void
    {
        $result = getContents($this->stub, $this->paths);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertIsArray($result[0]);
        $this->assertIsArray($result[1]);
    }

    /**
     * @throws \Exception
     */
    public function testGetPaths(): void
    {
        $result = getPaths($this->paths);
        $this->assertIsArray($result);
    }
}
