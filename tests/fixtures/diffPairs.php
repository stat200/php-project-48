<?php

return [
    'common' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'common',
            'expr'     => null,
            'status'   => null,
            'isOld'    => null,
            'path'     => 'common',
            'children' => [
                [
                    'name'     => 'follow',
                    'expr'     => false,
                    'status'   => 'ADDED',
                    'isOld'    => null,
                    'path'     => 'common.follow',
                    'children' => null,
                ],
                [
                    'name'     => 'setting1',
                    'expr'     => 'Value 1',
                    'status'   => null,
                    'isOld'    => null,
                    'path'     => 'common.setting1',
                    'children' => null,
                ],
                [
                    'name'     => 'setting2',
                    'expr'     => 200,
                    'status'   => 'DELETED',
                    'isOld'    => null,
                    'path'     => 'common.setting2',
                    'children' => null,
                ],
                [
                    'name'     => 'setting3',
                    'expr'     => true,
                    'status'   => 'CHANGED',
                    'isOld'    => true,
                    'path'     => 'common.setting3',
                    'children' => null,
                ],
                [
                    'name'     => 'setting3',
                    'expr'     => null,
                    'status'   => 'CHANGED',
                    'isOld'    => false,
                    'path'     => 'common.setting3',
                    'children' => null,
                ],
                [
                    'name'     => 'setting4',
                    'expr'     => 'blah blah',
                    'status'   => 'ADDED',
                    'isOld'    => null,
                    'path'     => 'common.setting4',
                    'children' => null,
                ],
                [
                    'name'     => 'setting5',
                    'expr'     => ['key5' => 'value5'],
                    'status'   => 'ADDED',
                    'isOld'    => null,
                    'path'     => 'common.setting5',
                    'children' => null,
                ],
                [
                    'name'     => 'setting6',
                    'expr'     => null,
                    'status'   => null,
                    'isOld'    => null,
                    'path'     => 'common.setting6',
                    'children' => [
                        [
                            'name'     => 'doge',
                            'expr'     => null,
                            'status'   => null,
                            'isOld'    => null,
                            'path'     => 'common.setting6.doge',
                            'children' => [
                                [
                                    'name'     => 'wow',
                                    'expr'     => '',
                                    'status'   => 'CHANGED',
                                    'isOld'    => true,
                                    'path'     => 'common.setting6.doge.wow',
                                    'children' => null,
                                ],
                                [
                                    'name'     => 'wow',
                                    'expr'     => 'so much',
                                    'status'   => 'CHANGED',
                                    'isOld'    => false,
                                    'path'     => 'common.setting6.doge.wow',
                                    'children' => null,
                                ],
                            ],
                        ],
                        [
                            'name'     => 'key',
                            'expr'     => 'value',
                            'status'   => null,
                            'isOld'    => null,
                            'path'     => 'common.setting6.key',
                            'children' => null,
                        ],
                        [
                            'name'     => 'ops',
                            'expr'     => 'vops',
                            'status'   => 'ADDED',
                            'isOld'    => null,
                            'path'     => 'common.setting6.ops',
                            'children' => null,
                        ],
                    ],
                ],
            ],
        ],
    ],

    'common.follow' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'follow',
            'expr'     => false,
            'status'   => 'ADDED',
            'isOld'    => null,
            'path'     => 'common.follow',
            'children' => null,
        ],
    ],

    'common.setting1' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'setting1',
            'expr'     => 'Value 1',
            'status'   => null,
            'isOld'    => null,
            'path'     => 'common.setting1',
            'children' => null,
        ],
    ],

    'common.setting2' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'setting2',
            'expr'     => 200,
            'status'   => 'DELETED',
            'isOld'    => null,
            'path'     => 'common.setting2',
            'children' => null,
        ],
    ],

    'common.setting3' => [
        'oldElem' => [
            'name'     => 'setting3',
            'expr'     => true,
            'status'   => 'CHANGED',
            'isOld'    => true,
            'path'     => 'common.setting3',
            'children' => null,
        ],
        'newElem' => [
            'name'     => 'setting3',
            'expr'     => null,
            'status'   => 'CHANGED',
            'isOld'    => false,
            'path'     => 'common.setting3',
            'children' => null,
        ],
        'currentElem' => null,
    ],

    'common.setting4' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'setting4',
            'expr'     => 'blah blah',
            'status'   => 'ADDED',
            'isOld'    => null,
            'path'     => 'common.setting4',
            'children' => null,
        ],
    ],

    'common.setting5' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'setting5',
            'expr'     => ['key5' => 'value5'],
            'status'   => 'ADDED',
            'isOld'    => null,
            'path'     => 'common.setting5',
            'children' => null,
        ],
    ],

    'common.setting6' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'setting6',
            'expr'     => null,
            'status'   => null,
            'isOld'    => null,
            'path'     => 'common.setting6',
            'children' => [
                [
                    'name'     => 'doge',
                    'expr'     => null,
                    'status'   => null,
                    'isOld'    => null,
                    'path'     => 'common.setting6.doge',
                    'children' => [
                        [
                            'name'     => 'wow',
                            'expr'     => '',
                            'status'   => 'CHANGED',
                            'isOld'    => true,
                            'path'     => 'common.setting6.doge.wow',
                            'children' => null,
                        ],
                        [
                            'name'     => 'wow',
                            'expr'     => 'so much',
                            'status'   => 'CHANGED',
                            'isOld'    => false,
                            'path'     => 'common.setting6.doge.wow',
                            'children' => null,
                        ],
                    ],
                ],
                [
                    'name'     => 'key',
                    'expr'     => 'value',
                    'status'   => null,
                    'isOld'    => null,
                    'path'     => 'common.setting6.key',
                    'children' => null,
                ],
                [
                    'name'     => 'ops',
                    'expr'     => 'vops',
                    'status'   => 'ADDED',
                    'isOld'    => null,
                    'path'     => 'common.setting6.ops',
                    'children' => null,
                ],
            ],
        ],
    ],

    'common.setting6.doge' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'doge',
            'expr'     => null,
            'status'   => null,
            'isOld'    => null,
            'path'     => 'common.setting6.doge',
            'children' => [
                [
                    'name'     => 'wow',
                    'expr'     => '',
                    'status'   => 'CHANGED',
                    'isOld'    => true,
                    'path'     => 'common.setting6.doge.wow',
                    'children' => null,
                ],
                [
                    'name'     => 'wow',
                    'expr'     => 'so much',
                    'status'   => 'CHANGED',
                    'isOld'    => false,
                    'path'     => 'common.setting6.doge.wow',
                    'children' => null,
                ],
            ],
        ],
    ],

    'common.setting6.doge.wow' => [
        'oldElem' => [
            'name'     => 'wow',
            'expr'     => '',
            'status'   => 'CHANGED',
            'isOld'    => true,
            'path'     => 'common.setting6.doge.wow',
            'children' => null,
        ],
        'newElem' => [
            'name'     => 'wow',
            'expr'     => 'so much',
            'status'   => 'CHANGED',
            'isOld'    => false,
            'path'     => 'common.setting6.doge.wow',
            'children' => null,
        ],
        'currentElem' => null,
    ],

    'common.setting6.key' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'key',
            'expr'     => 'value',
            'status'   => null,
            'isOld'    => null,
            'path'     => 'common.setting6.key',
            'children' => null,
        ],
    ],

    'common.setting6.ops' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'ops',
            'expr'     => 'vops',
            'status'   => 'ADDED',
            'isOld'    => null,
            'path'     => 'common.setting6.ops',
            'children' => null,
        ],
    ],

    'group1' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'group1',
            'expr'     => null,
            'status'   => null,
            'isOld'    => null,
            'path'     => 'group1',
            'children' => [
                [
                    'name'     => 'baz',
                    'expr'     => 'bas',
                    'status'   => 'CHANGED',
                    'isOld'    => true,
                    'path'     => 'group1.baz',
                    'children' => null,
                ],
                [
                    'name'     => 'baz',
                    'expr'     => 'bars',
                    'status'   => 'CHANGED',
                    'isOld'    => false,
                    'path'     => 'group1.baz',
                    'children' => null,
                ],
                [
                    'name'     => 'foo',
                    'expr'     => 'bar',
                    'status'   => null,
                    'isOld'    => null,
                    'path'     => 'group1.foo',
                    'children' => null,
                ],
                [
                    'name'     => 'nest',
                    'expr'     => ['key' => 'value'],
                    'status'   => 'CHANGED',
                    'isOld'    => true,
                    'path'     => 'group1.nest',
                    'children' => null,
                ],
                [
                    'name'     => 'nest',
                    'expr'     => 'str',
                    'status'   => 'CHANGED',
                    'isOld'    => false,
                    'path'     => 'group1.nest',
                    'children' => null,
                ],
            ],
        ],
    ],

    'group1.baz' => [
        'oldElem' => [
            'name'     => 'baz',
            'expr'     => 'bas',
            'status'   => 'CHANGED',
            'isOld'    => true,
            'path'     => 'group1.baz',
            'children' => null,
        ],
        'newElem' => [
            'name'     => 'baz',
            'expr'     => 'bars',
            'status'   => 'CHANGED',
            'isOld'    => false,
            'path'     => 'group1.baz',
            'children' => null,
        ],
        'currentElem' => null,
    ],

    'group1.foo' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'foo',
            'expr'     => 'bar',
            'status'   => null,
            'isOld'    => null,
            'path'     => 'group1.foo',
            'children' => null,
        ],
    ],

    'group1.nest' => [
        'oldElem' => [
            'name'     => 'nest',
            'expr'     => ['key' => 'value'],
            'status'   => 'CHANGED',
            'isOld'    => true,
            'path'     => 'group1.nest',
            'children' => null,
        ],
        'newElem' => [
            'name'     => 'nest',
            'expr'     => 'str',
            'status'   => 'CHANGED',
            'isOld'    => false,
            'path'     => 'group1.nest',
            'children' => null,
        ],
        'currentElem' => null,
    ],

    'group2' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'group2',
            'expr'     => [
                'abc'  => 12345,
                'deep' => ['id' => 45],
            ],
            'status'   => 'DELETED',
            'isOld'    => null,
            'path'     => 'group2',
            'children' => null,
        ],
    ],

    'group3' => [
        'oldElem' => null,
        'newElem' => null,
        'currentElem' => [
            'name'     => 'group3',
            'expr'     => [
                'deep' => ['id' => ['number' => 45]],
                'fee'  => 100500,
            ],
            'status'   => 'ADDED',
            'isOld'    => null,
            'path'     => 'group3',
            'children' => null,
        ],
    ],
];
