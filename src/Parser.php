<?php

namespace Gendiff\Parser;

function getParser(string $parserType): callable
{
    return parsers()[$parserType];
}

function parsers(): array
{
    return [
        'json' => function ($jsonString) {
            return json_decode($jsonString, true, 2, JSON_THROW_ON_ERROR);
        }
    ];
}
