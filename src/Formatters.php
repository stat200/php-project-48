<?php

namespace GenDiff\Formater;

use Hexlet\Code\exceptions\AstRuntimeException;

use function GenDiff\Helper\stringifyValue;

function getFormater(string $formatterType): callable
{
    return formatters()[$formatterType];
}

function formatters(): array
{
    return [
        'json' => function ($encodeStr) {
            return json_encode($encodeStr, JSON_THROW_ON_ERROR, 512);
        },
        'stylish' => function ($encodeStr) {
            return getArrayDiffFormat($encodeStr);
        }
    ];
}

function getStatusSign(?string $status, ?bool $flagIsOld = null): string
{
    switch ($status) {
        case 'ADDED':
            return '+';

        case 'DELETED':
            return '-';

        case 'CHANGED':
            if (true === $flagIsOld) {
                return '-';
            }

            if (false === $flagIsOld) {
                return '+';
            }

            if (is_null($flagIsOld)) {
                throw new AstRuntimeException();
            };

            break;

        default:
            return ' ';
    }
}

function getIndent(int $level, int $spaces, int $align): string
{
    return str_repeat(' ', ($level * $spaces) + $align);
}

function makeDiffFromArray(array $arr, int $level = 1): string
{
    $lines = ["{\n"];
    foreach ($arr as $key => $item) {
        $indent = getIndent($level, 4, 4);
        if (is_array($item)) {
            $nested = makeDiffFromArray($item, $level + 1);
            $lines[] = "{$indent}{$key}: {$nested}";
        } else {
            $value = stringifyValue($item);
            $lines[] = "{$indent}{$key}: {$value}\n";
        }
    }
    $closingIndent = getIndent($level - 1, 4, 4);
    $lines[] = "{$closingIndent}}\n";

    return implode('', $lines);
}

function getArrayDiffFormat(array $ast, int $level = 0): string
{
    $chunks = ["{\n"];
    foreach ($ast as $item) {
        $indent = getIndent($level, 4, 2);
        $statusSign = getStatusSign($item['status'], $item['isOld']);

        if (is_array($item['expr'])) {
            $nested = makeDiffFromArray($item['expr'], $level + 1);
            $chunks[] = "{$indent}{$statusSign} {$item['name']}: {$nested}";
        } elseif (is_array($item['children'])) {
            $nested = getArrayDiffFormat($item['children'], $level + 1);
            $chunks[] = "{$indent}{$statusSign} {$item['name']}: {$nested}";
        } else {
            $value = stringifyValue($item['expr']);
            $chunks[] = "{$indent}{$statusSign} {$item['name']}: {$value}\n";
        }
    }
    $closingIndent = getIndent($level, 4, 0);
    $chunks[] = "{$closingIndent}}\n";

    return implode('', $chunks);
}
