<?php

namespace GenDiff\formatters\PlainFormatter;

use GenDiff\Services\ChangeSetKeys;
use Hexlet\Code\exceptions\AstRuntimeException;

use function GenDiff\Utils\toStringLiteral;
use function GenDiff\formatters\diffFormat;
use function GenDiff\formatters\makeChain;
use function GenDiff\Services\formattersServices;

function makeChainHandlers(array $changeSet): array
{
    return [
        makeValueHandler($changeSet, ChangeSetKeys::OLD->value),
        makeValueHandler($changeSet, ChangeSetKeys::NEW->value),
        makeValueHandler($changeSet, ChangeSetKeys::CURRENT->value),
        makeDescriptionHandler()
    ];
}

function makeDescriptionHandler(): \Closure
{
    return function (array $elem, array $data): ?string {

        return match ($elem['status']) {
            'ADDED' =>
            "Property '{$elem['path']}' was added with value: {$data[ChangeSetKeys::CURRENT->value]}",

            'DELETED' =>
            "Property '{$elem['path']}' was removed",

            'CHANGED' =>
            $elem['isOld'] ? null : "Property '{$elem['path']}' was updated. "
                . "From {$data[ChangeSetKeys::OLD->value]} to {$data[ChangeSetKeys::NEW->value]}",

            null => null,

            default =>
                throw new AstRuntimeException('Unknown status.')
        };
    };
}

function makeValueHandler(array $changeSet, string $valueKey): \Closure
{
    return function (array $elem, array $data, callable $next) use ($changeSet, $valueKey): ?string {

        $value = $changeSet[$elem['path']][$valueKey]['expr'] ?? null;
        $data[$valueKey] = match (true) {
            is_array($value) => '[complex value]',
            is_string($value) => "'{$value}'",
            default => toStringLiteral($value),
        };

        return $next($elem, $data);
    };
}

function makeNestedElementsAccessor(): callable
{
    return fn(array $elem) => $elem['children'];
}

function buildStringsPostOrder(array $nodes, callable $getDescription, callable $getNestedElems): array
{
    $strings = [];
    foreach ($nodes as $elem) {
        $nestedElems = $getNestedElems($elem);

        if (!empty($nestedElems)) {
            foreach (buildStringsPostOrder($nestedElems, $getDescription, $getNestedElems) as $line) {
                $strings[] = $line;
            }
        }
        $strings[] = $getDescription($elem, []);
    }
    return $strings;
}

function plainFormat(array $ast): string
{
    $changeSet = formattersServices($ast)['makeChangeSet']();
    $handlers = makeChainHandlers($changeSet);
    $handlersDescription = makeChain($handlers);
    $getNestedElems = makeNestedElementsAccessor();
    $lines = buildStringsPostOrder($ast, $handlersDescription, $getNestedElems);
    return diffFormat($lines);
}
