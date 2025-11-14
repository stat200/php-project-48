<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use function GenDiff\Ast\getTemplate;
use function GenDiff\Ast\makeAst;

class AstTest extends TestCase
{
    public function testMakeAst(): void
    {
        $sourceArr1 = [
            "common" => [
                "setting1" => "Value 1",
                "setting2" => 200,
                "setting3" => true,
                "setting6" => [
                    "key"  => "value",
                    "doge" => [
                        "wow" => ""
                    ]
                ]
            ],
            "group1" => [
                "baz"  => "bas",
                "foo"  => "bar",
                "nest" => [
                    "key" => "value"
                ]
            ],
            "group2" => [
                "abc"  => 12345,
                "deep" => [
                    "id" => 45
                ]
            ]
        ];

        $sourceArr2 = [
            "common" => [
                "follow"   => false,
                "setting1" => "Value 1",
                "setting3" => null,
                "setting4" => "blah blah",
                "setting5" => [
                    "key5" => "value5"
                ],
                "setting6" => [
                    "key"  => "value",
                    "ops"  => "vops",
                    "doge" => [
                        "wow" => "so much"
                    ]
                ]
            ],
            "group1" => [
                "foo"  => "bar",
                "baz"  => "bars",
                "nest" => "str"
            ],
            "group3" => [
                "deep" => [
                    "id" => [
                        "number" => 45
                    ]
                ],
                "fee"  => 100500
            ]
        ];

        $expected = [
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

        $template = getTemplate('array');
        $result = makeAst($template, $sourceArr1, $sourceArr2);
        $this->assertEquals($expected, $result);
    }
}