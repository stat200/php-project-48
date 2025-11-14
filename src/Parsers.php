<?php

namespace Gendiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function getParser(string $parserType): callable
{
    return parsers()[$parserType];
}

function parsers(): array
{
    return [
        'json' => function ($jsonString) {
            return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
        },
        'yaml' => function ($yamlString) {
            return Yaml::parse($yamlString);
        }
    ];
}
