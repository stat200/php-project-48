<?php

namespace Tests;

use Hexlet\Code\exceptions\AstRuntimeException;
use PHPUnit\Framework\TestCase;

use function GenDiff\Formater\getFormater;
use function GenDiff\Formater\getArrayDiffFormat;
use function GenDiff\Formater\getIndent;
use function GenDiff\Formater\getStatusSign;
use function GenDiff\Formater\makeDiffFromArray;

class FormatersTest extends TestCase
{
    public function testFormatToJsonException(): void
    {
        $this->expectException(\JsonException::class);
        getFormater('json')("\xB1\x31");
    }

    public function testGetArrayDiffFormat(): void
    {
        $expected = "{
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
";
        $ast = [
            [
                'name'     => 'common',
                'expr'     => null,
                'isOld'    => null,
                'status'   => null,
                'children' => [
                    [
                        'name'     => 'follow',
                        'expr'     => false,
                        'isOld'    => null,
                        'status'   => 'ADDED',
                        'children' => null,
                    ],
                    [
                        'name'     => 'setting1',
                        'expr'     => 'Value 1',
                        'isOld'    => null,
                        'status'   => null,
                        'children' => null,
                    ],
                    [
                        'name'     => 'setting2',
                        'expr'     => 200,
                        'isOld'    => null,
                        'status'   => 'DELETED',
                        'children' => null,
                    ],
                    [
                        'name'     => 'setting3',
                        'expr'     => true,
                        'isOld'    => true,
                        'status'   => 'CHANGED',
                        'children' => null,
                    ],
                    [
                        'name'     => 'setting3',
                        'expr'     => null,
                        'isOld'    => false,
                        'status'   => 'CHANGED',
                        'children' => null,
                    ],
                    [
                        'name'     => 'setting4',
                        'expr'     => 'blah blah',
                        'isOld'    => null,
                        'status'   => 'ADDED',
                        'children' => null,
                    ],
                    [
                        'name'     => 'setting5',
                        'expr'     => ['key5' => 'value5'],
                        'isOld'    => null,
                        'status'   => 'ADDED',
                        'children' => null,
                    ],
                    [
                        'name'     => 'setting6',
                        'expr'     => null,
                        'isOld'    => null,
                        'status'   => null,
                        'children' => [
                            [
                                'name'     => 'doge',
                                'expr'     => null,
                                'isOld'    => null,
                                'status'   => null,
                                'children' => [
                                    [
                                        'name'     => 'wow',
                                        'expr'     => '',
                                        'isOld'    => true,
                                        'status'   => 'CHANGED',
                                        'children' => null,
                                    ],
                                    [
                                        'name'     => 'wow',
                                        'expr'     => 'so much',
                                        'isOld'    => false,
                                        'status'   => 'CHANGED',
                                        'children' => null,
                                    ],
                                ],
                            ],
                            [
                                'name'     => 'key',
                                'expr'     => 'value',
                                'isOld'    => null,
                                'status'   => null,
                                'children' => null,
                            ],
                            [
                                'name'     => 'ops',
                                'expr'     => 'vops',
                                'isOld'    => null,
                                'status'   => 'ADDED',
                                'children' => null,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'name'     => 'group1',
                'expr'     => null,
                'isOld'    => null,
                'status'   => null,
                'children' => [
                    [
                        'name'     => 'baz',
                        'expr'     => 'bas',
                        'isOld'    => true,
                        'status'   => 'CHANGED',
                        'children' => null,
                    ],
                    [
                        'name'     => 'baz',
                        'expr'     => 'bars',
                        'isOld'    => false,
                        'status'   => 'CHANGED',
                        'children' => null,
                    ],
                    [
                        'name'     => 'foo',
                        'expr'     => 'bar',
                        'isOld'    => null,
                        'status'   => null,
                        'children' => null,
                    ],
                    [
                        'name'     => 'nest',
                        'expr'     => ['key' => 'value'],
                        'isOld'    => true,
                        'status'   => 'CHANGED',
                        'children' => null,
                    ],
                    [
                        'name'     => 'nest',
                        'expr'     => 'str',
                        'isOld'    => false,
                        'status'   => 'CHANGED',
                        'children' => null,
                    ],
                ],
            ],
            [
                'name'     => 'group2',
                'expr'     => [
                    'abc'  => 12345,
                    'deep' => ['id' => 45],
                ],
                'isOld'    => null,
                'status'   => 'DELETED',
                'children' => null,
            ],
            [
                'name'     => 'group3',
                'expr'     => [
                    'deep' => ['id' => ['number' => 45]],
                    'fee'  => 100500,
                ],
                'isOld'    => null,
                'status'   => 'ADDED',
                'children' => null,
            ],
        ];

        $result = getArrayDiffFormat($ast);
        $this->assertEquals($expected, $result);
    }

    public function testGetIndent(): void
    {
        $result = getIndent(1, 2, 1);
        $this->assertEquals('   ', $result);
    }

    public function testMakeDiffFromArray(): void
    {
        $source = ['id' => ['number' => 45]];

        $expected = '{
        id: {
            number: 45
        }
    }
';
        $result = makeDiffFromArray($source);

        $this->assertEquals($expected, $result);
    }

    public function testGetStatusSign(): void
    {
        $result = getStatusSign('CHANGED', false);
        $this->assertEquals('+', $result);

        $result = getStatusSign('CHANGED', true);
        $this->assertEquals('-', $result);

        $this->expectException(AstRuntimeException::class);
        getStatusSign('CHANGED', null);

        $result = getStatusSign(null);
        $this->assertEquals(' ', $result);

        $result = getStatusSign('ADDED');
        $this->assertEquals('+', $result);

        $result = getStatusSign('DELETED');
        $this->assertEquals('-', $result);
    }
}
