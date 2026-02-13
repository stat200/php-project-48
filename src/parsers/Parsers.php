<?php

namespace GenDiff\Parsers;

use Symfony\Component\Yaml\Yaml;

function parsers(): array
{
    return [
        'json' => fn ($jsonString) => json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR),
        'yaml' => fn ($yamlString) => Yaml::parse($yamlString),
    ];
}
