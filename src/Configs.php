<?php

namespace GenDiff\Configs;

use Hexlet\Code\exceptions\UnsupportedFormatTypeException;

use function Config\getParams;

function getParam(string $configType, string $paramType, ?callable $getParams = null): string
{
    $getParams ??= getParams();
    $params = $getParams()[$configType];
    if (in_array($paramType, $params['list'], true)) {
        return $paramType;
    }
    return $params['default'];
}

function getContentFormat(string $contentType): string
{
    $map = [
    'application/json' => 'json',
    'text/plain' => 'yaml',
    'text/yaml' => 'yaml',
    ];

    if (!array_key_exists($contentType, $map)) {
        throw new UnsupportedFormatTypeException();
    }
    return $map[$contentType];
}
