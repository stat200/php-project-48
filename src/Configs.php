<?php

namespace GenDiff\Configs;

use Hexlet\Code\exceptions\UnsupportedFormatterTypeException;
use Hexlet\Code\exceptions\UnsupportedParserTypeException;

enum ParamType: string
{
    case Parser = 'parser';
    case Formatter = 'formatter';
}

function getParam(ParamType $type, ?string $paramRequest = null): string
{
    [$types, $exception] = match ($type) {
        ParamType::Parser => [getParserType(), UnsupportedParserTypeException::class],
        ParamType::Formatter => [getFormatterType(), UnsupportedFormatterTypeException::class],
    };

    return $paramRequest === null
        ? $types['default']
        : ($types[$paramRequest] ?? throw new $exception($paramRequest));
}

function getParserType(): array
{
    return [
        'json' => 'json',
        'yaml' => 'yaml',
        'default' => 'json',
    ];
}

function getFormatterType(): array
{
    return [
        'stylish' => 'stylish',
        'plain' => 'plain',
        'default' => 'stylish'
    ];
}
