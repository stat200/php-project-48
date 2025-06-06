<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\FileService\getContent;
use function GenDiff\FileService\getContentType;
use function GenDiff\FileService\isReadable;
use function GenDiff\FileService\getPath;

class FileServiceTest extends TestCase
{
    private string $path;

    protected function setUp(): void
    {
        $this->path = 'tests/fixtures/test.file';
    }
    public function testIsReadableException(): void
    {
        $this->expectException(\Exception::class);
        isReadable($this->path);
    }

    public function testGetContentException(): void
    {
        $this->expectException(\Exception::class);
        getContent($this->path);
    }

    public function testGetPathException(): void
    {
        $this->expectException(\Exception::class);
        getPath($this->path);
    }

    public function testGetContentTypeIsSupportedFileTypeException(): void
    {
        $this->expectException(\Exception::class);
        getContentType($this->path);
    }
}
