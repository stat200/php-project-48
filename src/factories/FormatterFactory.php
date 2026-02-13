<?php

namespace GenDiff\Factories;

use Hexlet\Code\exceptions\UnsupportedFormatterTypeException;

use function GenDiff\Formatters\formatters;

function getFormatter(string $formatterType): \Closure
{
    $formatter = formatters();

    if (!array_key_exists($formatterType, $formatter)) {
        throw new UnsupportedFormatterTypeException("Parser type '{$formatterType}' is not supported.");
    }

    return $formatter[$formatterType];
}
