<?php

namespace GenDiff\Formatters;

use function GenDiff\formatters\PlainFormatter\plainFormat;
use function GenDiff\formatters\StylishFormatter\stylishFormat;

function formatters(): array
{
    return [
        'plain' => fn (array $ast) => plainFormat($ast),
        'stylish' => fn (array $ast) => stylishFormat($ast),
    ];
}
