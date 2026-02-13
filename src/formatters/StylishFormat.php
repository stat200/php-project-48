<?php

namespace GenDiff\formatters\StylishFormatter;

use Hexlet\Code\exceptions\AstRuntimeException;

use function GenDiff\Utils\toStringLiteral;

const DIFF_MARKER_SHIFT = -2;

function stylishFormat(array $ast): string
{
    return trim(formatBlock($ast, 0));
}

function formatBlock(array $nodes, int $level): string
{
    $lines = [];
    foreach ($nodes as $node) {
        $lines[] = formatNode($node, $level + 1);
    }

    $indent = getIndent($level);
    $body = implode("", $lines);
    return "{\n{$body}{$indent}}\n";
}

function formatNode(array $node, int $level): string
{
    $indent = getIndent($level, DIFF_MARKER_SHIFT);
    $linePrefix = makeLinePrefix($node, $indent);
    if (!empty($node['children'])) {
        $block = formatBlock($node['children'], $level);
        return "{$linePrefix} {$block}";
    }

    $value = formatValueBlock($node, $level);
    return "{$linePrefix} {$value}\n";
}

function formatValueBlock(array $node, int $level): string
{
    return match (true) {
        is_array($node['expr']) => formatComplexValue($node['expr'], $level + 1),
        default => toStringLiteral($node['expr']),
    };
}

function formatComplexValue(array $complexValue, int $level): string
{
    $openIndent = getIndent($level);
    $closeIndent = getIndent($level - 1);

    $lines = [];

    foreach ($complexValue as $key => $value) {
        $linePrefix = "{$openIndent}{$key}: ";
        if (is_array($value)) {
            $lines[] = "{$linePrefix}" . formatComplexValue($value, $level + 1);
        } else {
            $lines[] = "{$linePrefix}" . toStringLiteral($value);
        }
    }

    $body = implode("\n", $lines);
    return "{\n{$body}\n{$closeIndent}}";
}

function makeLinePrefix(array $node, string $indent): string
{
    switch ($node['status']) {
        case 'ADDED':
            return "{$indent}+ {$node['name']}:";
        case 'DELETED':
            return "{$indent}- {$node['name']}:";
        case 'CHANGED':
            if ($node['isOld'] === false) {
                return "{$indent}+ {$node['name']}:";
            }

            if ($node['isOld'] === true) {
                return "{$indent}- {$node['name']}:";
            }

            throw new AstRuntimeException(
                "Unexpected isOld flag value for CHANGED node"
            );

        case null:
            return "{$indent}  {$node['name']}:";
        default:
            throw new AstRuntimeException("Unexpected node status: {$node['status']}");
    }
}

function getIndent(int $level, int $shift = 0): string
{
    return str_repeat(' ', max(0, $level * 4 + $shift));
}
