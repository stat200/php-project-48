<?php

namespace Tests\Differentiator;

use Exception;
use PHPUnit\Framework\TestCase;

use function Differentiator\genDiff;

class DifferentiatorTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGenDiffWithMinimumJsonFiles(): void
    {
        $file1 = __DIR__ . '/../../fixtures/file1Minimum.json';
        $file2 = __DIR__ . '/../../fixtures/file2Minimum.json';

        $expected = <<<DIFF
        {
          - timeout: 50
          + timeout: 20
        }
        DIFF;

        $this->assertSame($expected, genDiff($file1, $file2));
    }

    /**
     * @throws Exception
     */
    public function testGenDiffWithIdenticalJson(): void
    {
        $file1 = __DIR__ . '/../../fixtures/file1same.json';
        $file2 = __DIR__ . '/../../fixtures/file2same.json';

        $expected = <<<DIFF
        {
            follow: false
            host: hexlet.io
            proxy: 123.234.53.22
            timeout: 50
        }
        DIFF;

        $this->assertSame($expected, genDiff($file1, $file2));
    }

    /**
     * @throws Exception
     */
    public function testGenDiffWithAddedAndRemovedKeys(): void
    {
        $file1 = __DIR__ . '/../../fixtures/file1.json';
        $file2 = __DIR__ . '/../../fixtures/file2.json';

        $expected = <<<DIFF
        {
          - follow: false
            host: hexlet.io
          - proxy: 123.234.53.22
          - timeout: 50
          + timeout: 20
          + verbose: true
        }
        DIFF;

        $this->assertSame($expected, genDiff($file1, $file2));
    }

    /**
     * @throws Exception
     */
    public function testGenDiffWithYaml(): void
    {
        $file1 = __DIR__ . '/../../fixtures/file1.yaml';
        $file2 = __DIR__ . '/../../fixtures/file2.yaml';

        $expected = <<<DIFF
        {
          - follow: false
            host: hexlet.io
          - proxy: 123.234.53.22
          - timeout: 50
          + timeout: 20
          + verbose: true
        }
        DIFF;

        $this->assertSame($expected, genDiff($file1, $file2));
    }

    /**
     * @throws Exception
     */
    public function testGenDiffNested(): void
    {
        $file1 = __DIR__ . '/../../fixtures/file1Nested.json';
        $file2 = __DIR__ . '/../../fixtures/file2Nested.json';

        $expected = <<<DIFF
         {
             common: {
               + follow: false
                 setting1: Value 1
               - setting2: 200
               - setting3: true
               + setting3: null
               + setting4: blah blah
               + setting5: {
                     key5: value5
                 }
                 setting6: {
                     doge: {
                       - wow: 
                       + wow: so much
                     }
                     key: value
                   + ops: vops
                 }
             }
             group1: {
               - baz: bas
               + baz: bars
                 foo: bar
               - nest: {
                     key: value
                 }
               + nest: str
             }
           - group2: {
                 abc: 12345
                 deep: {
                     id: 45
                 }
             }
           + group3: {
                 deep: {
                     id: {
                         number: 45
                     }
                 }
                 fee: 100500
             }
         }
         DIFF;
        $this->assertSame($expected, genDiff($file1, $file2));
    }

    public function testGenDiffFirstEmptyFile(): void
    {
        $file1 = __DIR__ . '/../../fixtures/empty.json';
        $file2 = __DIR__ . '/../../fixtures/file2.json';

        $expected = <<<DIFF
        {
          + host: hexlet.io
          + timeout: 20
          + verbose: true
        }
        DIFF;
        $this->assertSame($expected, genDiff($file1, $file2));
    }

    public function testGenDiffSecondEmptyFile(): void
    {
        $file1 = __DIR__ . '/../../fixtures/file2.json';
        $file2 = __DIR__ . '/../../fixtures/empty.json';

        $expected = <<<DIFF
        {
          - host: hexlet.io
          - timeout: 20
          - verbose: true
        }
        DIFF;
        $this->assertSame($expected, genDiff($file1, $file2));
    }

    public function testGenDiffEmptyFiles(): void
    {
        $file1 = __DIR__ . '/../../fixtures/empty.json';
        $file2 = __DIR__ . '/../../fixtures/empty.json';

        $expected = <<<DIFF
        {
        }
        DIFF;
        $this->assertSame($expected, genDiff($file1, $file2));
    }

    /**
     * @throws Exception
     */
    public function testGenDiffFirstFileDoesntExist(): void
    {
        $file1 = __DIR__ . '/../../fixtures/qwe.json';
        $file2 = __DIR__ . '/../../fixtures/file2.json';

        $this->expectException(Exception::class);
        genDiff($file1, $file2);
    }

    /**
     * @throws Exception
     */
    public function testGenDiffDifferentFilesTypes(): void
    {
        $file1 = __DIR__ . '/../../fixtures/file1.json';
        $file2 = __DIR__ . '/../../fixtures/file2.yaml';

        $this->expectException(\InvalidArgumentException::class);
        genDiff($file1, $file2);
    }

    /**
     * @throws Exception
     */
    public function testGenDiffIdempotency(): void
    {
        $file1 = __DIR__ . '/../../fixtures/file1.json';
        $file2 = __DIR__ . '/../../fixtures/file2.json';

        $this->assertSame(genDiff($file1, $file2), genDiff($file1, $file2));
    }

    /**
     * @throws Exception
     */
    public function testGenDiffWithValidJsonFiles(): void
    {
        $file1 = __DIR__ . '/../../fixtures/file1Nested.json';
        $file2 = __DIR__ . '/../../fixtures/file2Nested.json';

        $expected = <<<DIFF
         Property 'common.follow' was added with value: false
         Property 'common.setting2' was removed
         Property 'common.setting3' was updated. From true to null
         Property 'common.setting4' was added with value: 'blah blah'
         Property 'common.setting5' was added with value: [complex value]
         Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
         Property 'common.setting6.ops' was added with value: 'vops'
         Property 'group1.baz' was updated. From 'bas' to 'bars'
         Property 'group1.nest' was updated. From [complex value] to 'str'
         Property 'group2' was removed
         Property 'group3' was added with value: [complex value]
         DIFF;
        $this->assertSame($expected, genDiff($file1, $file2, 'plain'));
    }
}
