<?php

namespace Tests;

use InvalidArgumentException;
use OutOfRangeException;
use PHPUnit\Framework\TestCase;

use function GenDiff\Infrastructure\IO\FileSystem\getMimes;
use function GenDiff\Infrastructure\IO\FileSystem\isReadable;
use function GenDiff\Infrastructure\IO\FileSystem\getContent;
use function GenDiff\Infrastructure\IO\FileSystem\getPath;

class FileSystemTest extends TestCase
{
    private string $readable;
    private string $unreadable;
    private string $realFile;
    private string $fixtures = '/../fixtures/';
    protected function setUp(): void
    {
        $this->readable = __DIR__ . $this->fixtures . 'readable.txt';
        $this->unreadable = __DIR__ . $this->fixtures . 'unreadable.txt';
        chmod($this->readable, 0777);
        chmod($this->unreadable, 0000);
        $this->realFile = __DIR__ . $this->fixtures . 'foo.txt';
    }

    protected function tearDown(): void
    {
        // Восстановить права после тестов
        if (file_exists($this->unreadable)) {
            chmod($this->unreadable, 0644);
        }
    }

    /**
     * @throws \Exception
     */
    public function testIsReadableDoesNotThrowForReadableFile(): void
    {
        isReadable($this->readable);
        $this->addToAssertionCount(1);
    }

    /**
     * @throws \Exception
     */
    public function testGetContentReturnsStringForReadableFile(): void
    {
        $content = getContent($this->readable);
        $this->assertSame('Hello, world', $content);
    }

    /**
     * @throws \Exception
     */
    public function testGetPathReturnsCanonicalPathForExistingFile(): void
    {
        $resolved = getPath($this->realFile);
        $this->assertSame(realpath($this->realFile), $resolved);
        $this->assertFileExists($resolved);
    }

    public function testIsReadableException(): void
    {
        $this->expectException(\Exception::class);
        isReadable($this->unreadable);
    }

    public function testGetContentException(): void
    {
        $this->expectException(\Exception::class);
        getContent($this->unreadable);
    }

    public function testGetPathException(): void
    {
        $this->expectException(\Exception::class);
        getPath($this->fixtures . 'unreadable.txt.txt');
    }

    public function testReturnsLowercasedMimesForTwoFiles(): void
    {
        $paths = [
            10 => __DIR__ . $this->fixtures . 'file1Multidimensional.yaml',
            20 => __DIR__ . $this->fixtures . 'file1Multidimensional.json'
        ];
        $result = getMimes($paths);

        $expectedYaml  = 'text/plain';
        $expectedJson = 'application/json';

        $this->assertSame($expectedYaml, $result[10]);
        $this->assertSame($expectedJson, $result[20]);

        $this->assertSame($result[10], mb_strtolower($result[10], 'UTF-8'));
        $this->assertSame($result[20], mb_strtolower($result[20], 'UTF-8'));
    }


    /**
     * @throws OutOfRangeException
     * @throws InvalidArgumentException
     */
    public function testGetMimesExceptions(): void
    {
        $this->expectException(\OutOfRangeException::class);
        getMimes([]);

        $this->expectException(\InvalidArgumentException::class);
        getMimes([__DIR__ . $this->fixtures . 'file1Multidimensional.yaml', __DIR__ . $this->fixtures . 'file.bin']);
    }
}
