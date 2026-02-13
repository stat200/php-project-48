<?php

namespace Tests\Utils;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Hexlet\Code\exceptions\UnsupportedParserTypeException;

use function GenDiff\Utils\toStringLiteral;
use function GenDiff\Utils\getParserTypeByMime;
use function GenDiff\Utils\normalizeContentType;

class CommonUtilsTest extends TestCase
{
    #[DataProvider('toStringLiteralProvider')]
    public function testToStringLiteral(string|bool|null $input, string $expected): void
    {
        $this->assertSame($expected, toStringLiteral($input));
    }

    public static function toStringLiteralProvider(): array
    {
        return [
            'true boolean'  => [true, 'true'],
            'false boolean' => [false, 'false'],
            'null value'    => [null, 'null'],
            'string value'  => ['hello', 'hello'],
            'empty string'  => ['', ''],
            'numeric string' => ['123', '123'],
        ];
    }

    #[DataProvider('parserTypeProvider')]
    public function testGetParserTypeByMimeSuccess(string $mime, string $expected): void
    {
        $this->assertSame($expected, getParserTypeByMime($mime));
    }

    public static function parserTypeProvider(): array
    {
        return [
            ['application/json', 'json'],
            ['text/yaml', 'yaml'],
            ['text/plain', 'yaml'],
        ];
    }

    public function testGetParserTypeByMimeThrowsException(): void
    {
        $this->expectException(UnsupportedParserTypeException::class);
        getParserTypeByMime('application/xml');
    }

    #[DataProvider('NormalizeContentType')]
    public function testNormalizeContentType(string $input, string $expected): void
    {
        self::assertSame($expected, normalizeContentType($input));
    }

    public static function normalizeContentType(): array
    {
        return [
            'already normalized' => [
                'application/json',
                'application/json',
            ],
            'with charset' => [
                'application/json; charset=utf-8',
                'application/json',
            ],
            'with extra params' => [
                'text/plain; charset=utf-8; version=1',
                'text/plain',
            ],
            'uppercase' => [
                'Application/JSON',
                'application/json',
            ],
            'spaces around' => [
                '  text/yaml  ',
                'text/yaml',
            ],
        ];
    }

    public function testGetParserTypeByMimeThrowsForUnsupportedType(): void
    {
        $this->expectException(UnsupportedParserTypeException::class);

        getParserTypeByMime('application/xml');
    }
}
