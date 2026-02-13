<?php

namespace Tests\StylishFormat;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\exceptions\AstRuntimeException;

use function GenDiff\formatters\StylishFormatter\stylishFormat;
use function GenDiff\formatters\StylishFormatter\makeLinePrefix;

class StylishFormatTest extends TestCase
{
    public function testStylishFormatSingleElement(): void
    {
        $ast = [
            [
                'name'   => 'follow',
                'status' => 'ADDED',
                'expr'   => false,
            ],
        ];

        $expected = <<<TEXT
        {
          + follow: false
        }
        TEXT;

        $result = stylishFormat($ast);
        $this->assertSame($expected, $result);
    }

    public function testStylishFormatMultipleElements(): void
    {
        $ast = [
            [
                'name'   => 'follow',
                'status' => 'ADDED',
                'expr'   => false,
            ],
            [
                'name'   => 'setting1',
                'status' => null,
                'expr'   => 'Value 1',
            ],
        ];

        $expected = <<<TEXT
        {
          + follow: false
            setting1: Value 1
        }
        TEXT;

        $result = stylishFormat($ast);
        $this->assertSame($expected, $result);
    }

    public function testStylishFormatRendersChangedNodeAsRemovedAndAdded(): void
    {
        $ast = [
            [
                'name'     => 'setting3',
                'path'     => 'common.setting3',
                'expr'     => true,
                'isOld'    => true,
                'status'   => 'CHANGED',
                'children' => null,
            ],
            [
                'name'     => 'setting3',
                'path'     => 'common.setting3',
                'expr'     => null,
                'isOld'    => false,
                'status'   => 'CHANGED',
                'children' => null,
            ],
        ];

        $expected = <<<TEXT
        {
          - setting3: true
          + setting3: null
        }
        TEXT;

        $result = stylishFormat($ast);
        $this->assertSame($expected, $result);
    }

    public function testStylishFormatNestedStructure(): void
    {
        $ast = [
            [
                'name'     => 'setting6',
                'path'     => 'common.setting6',
                'expr'     => null,
                'isOld'    => null,
                'status'   => null,
                'children' => [
                    [
                        'name'     => 'doge',
                        'path'     => 'common.setting6.doge',
                        'expr'     => null,
                        'isOld'    => null,
                        'status'   => null,
                        'children' => [
                            [
                                'name'     => 'wow',
                                'path'     => 'common.setting6.doge.wow',
                                'expr'     => 'so much',
                                'isOld'    => null,
                                'status'   => null,
                                'children' => null,
                            ],
                        ],
                    ],
                ],
            ]
        ];
        $expected = <<<TEXT
        {
            setting6: {
                doge: {
                    wow: so much
                }
            }
        }
        TEXT;

        $result = stylishFormat($ast);
        $this->assertSame($expected, $result);
    }

    public function testStylishFormatNestedOldAndNewNodes(): void
    {
        $ast = [
            [
                'name'     => 'setting6',
                'path'     => 'common.setting6',
                'expr'     => null,
                'isOld'    => null,
                'status'   => null,
                'children' => [
                    [
                        'name'     => 'doge',
                        'path'     => 'common.setting6.doge',
                        'expr'     => null,
                        'isOld'    => null,
                        'status'   => null,
                        'children' => [
                            [
                                'name'     => 'wow',
                                'path'     => 'common.setting6.doge.wow',
                                'expr'     => '',
                                'isOld'    => true,
                                'status'   => 'CHANGED',
                                'children' => null,
                            ],
                            [
                                'name'     => 'wow',
                                'path'     => 'common.setting6.doge.wow',
                                'expr'     => 'so much',
                                'isOld'    => false,
                                'status'   => 'CHANGED',
                                'children' => null,
                            ],
                        ],
                    ],
                    [
                        'name'     => 'key',
                        'path'     => 'common.setting6.key',
                        'expr'     => 'value',
                        'isOld'    => null,
                        'status'   => null,
                        'children' => null,
                    ],
                    [
                        'name'     => 'ops',
                        'path'     => 'common.setting6.ops',
                        'expr'     => 'vops',
                        'isOld'    => null,
                        'status'   => 'ADDED',
                        'children' => null,
                    ],
                ],
            ],
        ];

        $expected = <<<TEXT
        {
            setting6: {
                doge: {
                  - wow: 
                  + wow: so much
                }
                key: value
              + ops: vops
            }
        }
        TEXT;

        $result = stylishFormat($ast);
        $this->assertSame($expected, $result);
    }

    public function testStylishFormatComplexValue(): void
    {
        $ast = [
            [
                'name'     => 'group2',
                'path'     => 'group2',
                'expr'     => [
                    'abc'  => 12345,
                    'deep' => [
                        'id' => 45,
                        'deeply' => [
                            'nested' => true,
                        ]
                    ],
                ],
                'isOld'    => null,
                'status'   => 'DELETED',
                'children' => null,
            ],
        ];

        $expected = <<<TEXT
        {
          - group2: {
                abc: 12345
                deep: {
                    id: 45
                    deeply: {
                        nested: true
                    }
                }
            }
        }
        TEXT;

        $result = stylishFormat($ast);
        $this->assertSame($expected, $result);
    }

    public function testStylishFormatIndentConsistency(): void
    {
        $ast = [
            [
                'name'     => 'root',
                'status'   => null,
                'expr'     => null,
                'children' => [
                    [
                        'name'   => 'added',
                        'status' => 'ADDED',
                        'expr'   => true,
                        'children' => null,
                    ],
                    [
                        'name'   => 'nested',
                        'status' => null,
                        'expr'   => null,
                        'children' => [
                            [
                                'name'   => 'deleted',
                                'status' => 'DELETED',
                                'expr'   => 10,
                                'children' => null,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $expected = <<<TEXT
        {
            root: {
              + added: true
                nested: {
                  - deleted: 10
                }
            }
        }
        TEXT;

        $this->assertSame($expected, stylishFormat($ast));
    }

    public function testMakeLinePrefixThrowsOnUnexpectedStatus(): void
    {
        $this->expectException(AstRuntimeException::class);
        $this->expectExceptionMessage("Unexpected node status: UNKNOWN");

        $node = [
            'name' => 'test',
            'status' => 'UNKNOWN',
            'expr' => null,
        ];

        makeLinePrefix($node, '    ');
    }

    public function testMakeLinePrefixThrowsOnUnexpectedIsOldFlag(): void
    {
        $this->expectException(AstRuntimeException::class);
        $this->expectExceptionMessage("Unexpected isOld flag value for CHANGED node");

        $node = [
            'name' => 'test',
            'status' => 'CHANGED',
            'expr' => null,
            'isOld' => 'invalid',
        ];

        makeLinePrefix($node, '    ');
    }
}
