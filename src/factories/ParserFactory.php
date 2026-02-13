<?php

namespace Gendiff\Factories;

use Hexlet\Code\exceptions\UnsupportedParserTypeException;

use function GenDiff\Parsers\parsers;

function getParser(string $parserType): \Closure
{
    $parsers = parsers();

    if (!array_key_exists($parserType, $parsers)) {
        throw new UnsupportedParserTypeException("Parser type '{$parserType}' is not supported.");
    }

    return $parsers[$parserType];
}
