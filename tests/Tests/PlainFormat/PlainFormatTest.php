<?php

namespace Tests\PlainFormat;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\exceptions\AstRuntimeException;
use GenDiff\Services\ChangeSetKeys;

use function GenDiff\formatters\makeChain;
use function GenDiff\formatters\diffFormat;
use function GenDiff\formatters\PlainFormatter\makeDescriptionHandler;
use function GenDiff\formatters\PlainFormatter\buildStringsPostOrder;

class PlainFormatTest extends TestCase
{
    public function testMakeChainExecutesHandlersInCorrectOrder(): void
    {
        $calls = [];

        $handler1 = function ($elem, $data, $next) use (&$calls) {
            $calls[] = 'handler1';
            return $next($elem, $data);
        };

        $handler2 = function ($elem, $data, $next) use (&$calls) {
            $calls[] = 'handler2';
            return $next($elem, $data);
        };

        $chain = makeChain([$handler1, $handler2]);

        $result = $chain([], []);

        $this->assertNull($result);
        $this->assertEquals(['handler1', 'handler2'], $calls);
    }

    public function testMakeChainWithEmptyHandlersReturnsNull(): void
    {
        $chain = makeChain([]);

        $result = $chain([], []);

        $this->assertNull($result);
    }

    public function testDiffFormatFiltersEmptyValues(): void
    {
        $lines = [
            "line1",
            null,
            "",
            "line2",
            false,
        ];

        $result = diffFormat($lines);

        $this->assertEquals("line1\nline2", $result);
    }

    public function testDiffFormatWithAllEmptyReturnsEmptyString(): void
    {
        $lines = [null, '', false];

        $result = diffFormat($lines);

        $this->assertEquals('', $result);
    }

    public function testAdded(): void
    {
        $handler = makeDescriptionHandler();

        $elem = [
            'status' => 'ADDED',
            'path' => 'key'
        ];

        $data = [
            ChangeSetKeys::CURRENT->value => "'value'"
        ];

        $this->assertEquals(
            "Property 'key' was added with value: 'value'",
            $handler($elem, $data)
        );
    }

    public function testDeleted(): void
    {
        $handler = makeDescriptionHandler();

        $elem = [
            'status' => 'DELETED',
            'path' => 'key'
        ];

        $this->assertEquals(
            "Property 'key' was removed",
            $handler($elem, [])
        );
    }

    public function testThrowsExceptionForUnknownStatus(): void
    {
        $this->expectException(AstRuntimeException::class);

        $handler = makeDescriptionHandler();

        $handler([
            'status' => 'UNKNOWN',
            'path' => 'key'
        ], []);
    }

    public function testPostOrderTraversal(): void
    {
        $nodes = [
            [
                'value' => 'parent',
                'children' => [
                    ['value' => 'child', 'children' => []]
                ]
            ]
        ];

        $getDescription = fn($elem) => $elem['value'];
        $getNested = fn($elem) => $elem['children'];

        $result = buildStringsPostOrder($nodes, $getDescription, $getNested);

        $this->assertEquals(['child', 'parent'], $result);
    }
}
