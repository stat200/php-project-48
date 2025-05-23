<?php

namespace Gendiff\Parser;

use JsonException;

/**
 * @throws JsonException
 */
function parseJson(string $jsonString): array
{
    return json_decode($jsonString, true, 512, JSON_THROW_ON_ERROR);
}
