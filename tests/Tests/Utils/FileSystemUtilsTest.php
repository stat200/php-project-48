<?php

namespace Tests\Utils;

use PHPUnit\Framework\TestCase;
use OutOfRangeException;
use RuntimeException;
use Exception;

use function GenDiff\Utils\getContent;
use function GenDiff\Utils\validateFile;
use function GenDiff\Utils\getPath;
use function GenDiff\Utils\getMimes;
use function GenDiff\Utils\isReadable;

class FileSystemUtilsTest extends TestCase
{
    private string $tempFile;

    protected function setUp(): void
    {
        $this->tempFile = tempnam(sys_get_temp_dir(), 'test_');
        file_put_contents($this->tempFile, 'test content');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        if (file_exists($this->tempFile)) {
            unlink($this->tempFile);
        }
    }

    public function testIsReadableThrowsException(): void
    {
        $this->expectException(Exception::class);
        isReadable('/path/to/not/existing/file.txt');
    }

    public function testValidateFileThrowsIfNotExists(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("File '/not/existing/file.txt' is not readable");
        validateFile('/not/existing/file.txt');
    }

    public function testValidateFileThrowsIfNotReadable(): void
    {
        $file = $this->tempFile;
        chmod($file, 0222);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("File '{$file}' is not readable");
        validateFile($file);

        chmod($file, 0644);
    }

    public function testReadFileSuccess(): void
    {
        $this->assertSame('test content', getContent($this->tempFile));
    }

    public function testGetContentSuccess(): void
    {
        $content = getContent($this->tempFile);
        $this->assertSame('test content', $content);
    }

    public function testGetContentThrowsIfNotReadable(): void
    {
        $file = $this->tempFile;
        chmod($file, 0222);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("File '{$file}' is not readable");

        getContent($file);

        chmod($file, 0644);
    }

    /**
     * @throws Exception
     */
    public function testGetPathSuccess(): void
    {
        $path = getPath($this->tempFile);
        $this->assertSame(realpath($this->tempFile), $path);
    }

    public function testGetPathThrowsException(): void
    {
        $this->expectException(Exception::class);
        getPath('/not/existing/file.txt');
    }

    public function testGetMimesSuccess(): void
    {
        $file1 = tempnam(sys_get_temp_dir(), 'mime_');
        $file2 = tempnam(sys_get_temp_dir(), 'mime_');

        file_put_contents($file1, 'text');
        file_put_contents($file2, 'text');

        $mimes = getMimes([$file1, $file2]);

        $this->assertCount(2, $mimes);
        $this->assertContains('text/plain', $mimes);

        unlink($file1);
        unlink($file2);
    }

    public function testGetMimesThrowsIfWrongCount(): void
    {
        $this->expectException(OutOfRangeException::class);
        getMimes([$this->tempFile]);
    }

    public function testGetMimesThrowsIfFileDoesNotExist(): void
    {
        $this->expectException(RuntimeException::class);
        getMimes([$this->tempFile, '/not/existing/file.txt']);
    }
}
