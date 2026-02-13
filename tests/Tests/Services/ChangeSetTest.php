<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;

use function GenDiff\Services\formattersServices;

class ChangeSetTest extends TestCase
{
    private const SERVICE_NAME = 'makeChangeSet';

    public function testReturnedValueIsArray(): void
    {
        $this->assertIsArray(formattersServices([])[self::SERVICE_NAME]());
    }

    public function testReturnedValue(): void
    {
        $diffPairs = require(__DIR__ . '/../../fixtures/diffPairs.php');
        $ast = require(__DIR__ . '/../../fixtures/ast.php');
        $this->assertEquals($diffPairs, formattersServices($ast)[self::SERVICE_NAME]());
    }

    public function testReturnEmptyArrayWithEmptyAst(): void
    {
        $this->assertEmpty(formattersServices([])[self::SERVICE_NAME]());
    }

    public function testSetOldElemOldIsTrue(): void
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
        $diffPairs = formattersServices($ast)[self::SERVICE_NAME]();
        $this->assertArrayHasKey('common.setting3', $diffPairs);
        $this->assertEquals($ast[0], $diffPairs['common.setting3']['oldElem']);
        $this->assertArrayHasKey('newElem', $diffPairs[$ast[0]['path']]);
    }

    public function testSetOldElemOldIsFalse(): void
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
        $diffPairs = formattersServices($ast)[self::SERVICE_NAME]();
        $this->assertArrayHasKey('common.setting3', $diffPairs);
        $this->assertEquals($ast[1], $diffPairs['common.setting3']['newElem']);
        $this->assertArrayHasKey('newElem', $diffPairs[$ast[0]['path']]);
    }

    public function testSetNullOldIsNull(): void
    {
        $ast = [
            [
                'name'     => 'setting2',
                'path'     => 'common.setting2',
                'expr'     => 200,
                'isOld'    => null,
                'status'   => 'DELETED',
                'children' => null,
            ],
        ];
        $diffPairs = formattersServices($ast)[self::SERVICE_NAME]();
        $this->assertNull($diffPairs['common.setting2']['oldElem']);
        $this->assertNull($diffPairs['common.setting2']['newElem']);
    }

    public function testNestingHandling(): void
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
                ],
            ],
        ];
        $diffPairs = formattersServices($ast)[self::SERVICE_NAME]();
        $this->assertCount(3, $diffPairs);
        $this->assertArrayHasKey('common.setting6', $diffPairs);
        $this->assertArrayHasKey('common.setting6.doge', $diffPairs);
        $this->assertArrayHasKey('common.setting6.doge.wow', $diffPairs);
    }

    public function testChildrenIsEmpty(): void
    {
        $ast = [
            [
                'name'     => 'setting6',
                'path'     => 'common.setting6',
                'expr'     => null,
                'isOld'    => null,
                'status'   => null,
                'children' => [],
            ],
        ];
        $diffPairs = formattersServices($ast)[self::SERVICE_NAME]();
        $this->assertCount(1, $diffPairs);
        $this->assertArrayHasKey('common.setting6', $diffPairs);
    }
}
