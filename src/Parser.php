<?php

namespace Gendiff\Parser;

/**
 * @throws \JsonException
 */
function parseJson(string $jsonString): array
{
    return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
}

/**
 * @throws \JsonException
 */
function getJson(array $jsonString): string
{
    return json_encode($jsonString, JSON_THROW_ON_ERROR);
}
