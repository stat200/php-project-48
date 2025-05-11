<?php

namespace Differentiator;

use function Gendiff\Parser\parseJson;
use function GenDiff\FileService\getContents;

/**
 * @throws \JsonException
 * @throws \Exception
 */
function genDiff($pathToFile1, $pathToFile2): string
{
    $diff = [];

    $content1 = getContent($pathToFile1);
    $content2 = getContent($pathToFile2);
    $intersect = array_intersect_assoc($content1, $content2);
    $diff1 = array_diff_assoc($content1, $content2);
    $diff2 = array_diff_assoc($content2, $content1);
    $keys = array_merge(array_keys($intersect), array_keys($diff1), array_keys($diff2));
    sort($keys, SORT_STRING);

    foreach ($keys as $key) {
        if (array_key_exists($key, $intersect)) {
            $diff[$key] = $intersect[$key];
            continue;
        }

        if (array_key_exists($key, $diff1)) {
            $diff["-{$key}"] = $diff1[$key];
        }

        if (array_key_exists($key, $diff2)) {
            $diff["+{$key}"] = $diff2[$key];
        }
    };

    return json_encode($diff);
}

/**
 * @throws \JsonException
 * @throws \Exception
 */
function getContent($path): array
{
    $file = realpath($path);
    return parseJson(getContents($file));
}
