<?php

namespace Tests\Ast;

use PHPUnit\Framework\TestCase;

use function GenDiff\Ast\makeAst;

class Ast extends TestCase
{
    private \Closure $template;

    protected function setUp(): void
    {
        $this->template = function (
            string $key,
            $item,
            ?string $status,
            ?bool $isOldFlag,
            string $path,
            ?array $children
        ) {
            return [
                'name' => $key,
                'expr' => $item,
                'status' => $status,
                'isOld' => $isOldFlag,
                'path' => $path,
                'children' => $children,
            ];
        };
    }

    public function testMakeAstEmptyArrays(): void
    {
        $arr1 = [];
        $arr2 = [];

        $this->assertSame([], makeAst($arr1, $arr2, $this->template));
    }

    public function testMakeAstSameKey(): void
    {
        $arr1 = [
            'setting1' => 'value1'
        ];

        $arr2 = [
            'setting1' => 'value1'
        ];

        $expected = [
            ($this->template)(
                'setting1',
                'value1',
                null,
                null,
                'setting1',
                null
            )
        ];

        $this->assertSame($expected, makeAst($arr1, $arr2, $this->template));
    }

    public function testMakeAstMultipleExpressions(): void
    {
        $arr1 = [
            'timeout' => '50',
            'follow' => 'setting2'
        ];

        $arr2 = [
            'timeout' => '50',
            'follow' => 'setting2'
        ];

        $expected = [
            ($this->template)(
                'follow',
                'setting2',
                null,
                null,
                'follow',
                null
            ),
            ($this->template)(
                'timeout',
                '50',
                null,
                null,
                'timeout',
                null
            ),
        ];

        $this->assertSame($expected, makeAst($arr1, $arr2, $this->template,));
    }

    public function testMakeAstDeletedExpression(): void
    {
        $arr1 = [
            'setting1' => 'value1'
        ];
        $arr2 = [];

        $expected = [
            ($this->template)(
                'setting1',
                'value1',
                'DELETED',
                null,
                'setting1',
                null
            ),
        ];

        $this->assertSame($expected, makeAst($arr1, $arr2, $this->template,));
    }

    public function testMakeAstAddedExpression(): void
    {
        $arr1 = [];
        $arr2 = [
            'setting1' => 'value1'
        ];

        $expected = [
            ($this->template)(
                'setting1',
                'value1',
                'ADDED',
                null,
                'setting1',
                null
            ),
        ];
        $this->assertSame($expected, makeAst($arr1, $arr2, $this->template));
    }

    public function testMakeAstSameKeysDifferentValues(): void
    {
        $arr1 = [
            'timeout' => '50'
        ];

        $arr2 = [
            'timeout' => '20'
        ];

        $expected = [
            ($this->template)(
                'timeout',
                '50',
                'CHANGED',
                true,
                'timeout',
                null
            ),
            ($this->template)(
                'timeout',
                '20',
                'CHANGED',
                false,
                'timeout',
                null
            ),
        ];

        $this->assertSame($expected, makeAst($arr1, $arr2, $this->template));
    }

    public function testMakeAstValueIsComplex(): void
    {
        $arr1 = [
            'setting6' => [
                'doge' => [
                    'wow' => '',
                ],
            ],
        ];

        $arr2 = [
            'setting6' => 'string6'
        ];

        $expected = [
            ($this->template)(
                'setting6',
                ['doge' => ['wow' => '']],
                'CHANGED',
                true,
                'setting6',
                null
            ),
            ($this->template)(
                'setting6',
                'string6',
                'CHANGED',
                false,
                'setting6',
                null
            ),
        ];

        $this->assertSame($expected, makeAst($arr1, $arr2, $this->template));
    }

    public function testMakeAstNestedElement(): void
    {
        $arr1 = [
            'setting6' => [
                'doge' => [
                    'wow' => '',
                ],
            ],
        ];
        $arr2 = [
            'setting6' => [
                'doge' => [
                    'wow' => 'so much',
                ],
            ],
        ];

        $expected = [
            [
                'name'     => 'setting6',
                'expr'     => null,
                'status'   => null,
                'isOld'    => null,
                'path'     => 'setting6',
                'children' => [
                    [
                        'name'     => 'doge',
                        'expr'     => null,
                        'status'   => null,
                        'isOld'    => null,
                        'path'     => 'setting6.doge',
                        'children' => [
                            ($this->template)(
                                'wow',
                                '',
                                'CHANGED',
                                true,
                                'setting6.doge.wow',
                                null
                            ),
                             ($this->template)(
                                 'wow',
                                 'so much',
                                 'CHANGED',
                                 false,
                                 'setting6.doge.wow',
                                 null
                             ),
                        ],
                    ],
                ],
            ],
        ];
        $this->assertSame($expected, makeAst($arr1, $arr2, $this->template));
    }

    public function testMakeAstDeepNestedElement(): void
    {
        $arr1 = [
            'setting1' => [
                'doge' => [
                    'wow' => '',
                ],
                'setting2' => [
                    'setting3' => [
                        'deep' => 'scary'
                    ]
                ],
                'thing' => 'first'
            ],
        ];

        $arr2 = [
            'setting1' => [
                'doge' => [
                    'wow' => 'so much',
                ],
                'setting2' => [
                    'setting3' => '456'
                ],
                'thing1' => 'first',
                'thing2' => 'second'
            ],
        ];

        $expected = [
            ($this->template)(
                'setting1',
                null,
                null,
                null,
                'setting1',
                [
                    ($this->template)(
                        'doge',
                        null,
                        null,
                        null,
                        'setting1.doge',
                        [
                            ($this->template)(
                                'wow',
                                '',
                                'CHANGED',
                                true,
                                'setting1.doge.wow',
                                null
                            ),
                            ($this->template)(
                                'wow',
                                'so much',
                                'CHANGED',
                                false,
                                'setting1.doge.wow',
                                null
                            ),
                        ]
                    ),
                    ($this->template)(
                        'setting2',
                        null,
                        null,
                        null,
                        'setting1.setting2',
                        [
                            ($this->template)(
                                'setting3',
                                ['deep' => 'scary'],
                                'CHANGED',
                                true,
                                'setting1.setting2.setting3',
                                null
                            ),
                            ($this->template)(
                                'setting3',
                                '456',
                                'CHANGED',
                                false,
                                'setting1.setting2.setting3',
                                null
                            ),
                        ]
                    ),
                    ($this->template)(
                        'thing',
                        'first',
                        'DELETED',
                        null,
                        'setting1.thing',
                        null
                    ),
                    ($this->template)(
                        'thing1',
                        'first',
                        'ADDED',
                        null,
                        'setting1.thing1',
                        null
                    ),
                    ($this->template)(
                        'thing2',
                        'second',
                        'ADDED',
                        null,
                        'setting1.thing2',
                        null
                    ),
                ]
            ),
        ];

        $this->assertSame($expected, makeAst($arr1, $arr2, $this->template));
    }
}
