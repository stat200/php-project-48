<?php

namespace Differentiator;

use function Gendiff\Parser\parseJson;
use function GenDiff\FileService\getContent;
use function Gendiff\FileService\isReadable;
use function GenDiff\FileService\getPath;

/**
 * @throws \Exception
 */
function genDiff($pathToFile1, $pathToFile2): ?string
{
    $diff = [];
    try {
        $contents = getContents($pathToFile1, $pathToFile2);
    } catch (\Exception $e) {
        echo $e->getMessage();
        return null;
    };
    [$content1, $content2] = [...$contents];
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
            $diff["- {$key}"] = $diff1[$key];
        }

        if (array_key_exists($key, $diff2)) {
            $diff["+ {$key}"] = $diff2[$key];
        }
    };

    return json_encode($diff);
}

function getContents(string ...$paths): array
{
    return array_map(
        function ($path) {
            $realPath = getPath($path);
            isReadable($realPath);
            return parseJson(getContent($realPath));
        },
        $paths
    );
}
