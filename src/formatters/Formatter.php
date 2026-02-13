<?php

namespace GenDiff\formatters;

function makeChain(array $handlers): callable
{
    return array_reduce(
        array_reverse($handlers),
        fn ($next, $handler) =>
            fn (array $elem, array $data) => $handler($elem, $data, $next),
        fn (array $elem, array $data) => null
    );
}

function diffFormat(array $lines): string
{
    $filtered = array_filter($lines, fn($line) => (bool) $line);
    return implode("\n", $filtered);
}
