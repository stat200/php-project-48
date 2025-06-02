<?php

namespace Gendiff\Parser;

use JsonException;

/**
 * ParseJson
 *
 * Parse json with fixed params
 *
 * @param string $jsonString json string
 *
 * @throws JsonException
 *
 * @return array
 */
function parseJson(string $jsonString): array
{
    return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
}
