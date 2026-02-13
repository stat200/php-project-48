<?php

namespace GenDiff\Utils;

use Hexlet\Code\exceptions\UnsupportedParserTypeException;

function toStringLiteral(string|bool|null $value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    return (string) $value;
}


function getParserTypeByMime(string $mimeType): string
{
    $map = [
        'application/json' => 'json',
        'text/yaml'        => 'yaml',
        'text/plain'       => 'yaml',
    ];

    if (!array_key_exists($mimeType, $map)) {
        throw new  UnsupportedParserTypeException($mimeType);
    }

    return $map[$mimeType];
}

function normalizeContentType(string $contentType): string
{
    return strtolower(trim(explode(';', $contentType, 2)[0]));
}
