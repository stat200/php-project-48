<?php

namespace Differentiator;

use function GenDiff\Encoder\getEncoder;
use function Gendiff\Parser\getParser;
use function GenDiff\FileService\getContent;
use function Gendiff\FileService\isReadable;
use function GenDiff\FileService\getPath;

const CONTENT_TYPES = ['json'];
/**
 * @throws \Exception
 */
function genDiff(string $pathToFile1, string $pathToFile2): string
{
    $diff = [];

    $contents = getContents(CONTENT_TYPES[0], $pathToFile1, $pathToFile2);
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

    return getEncoder(CONTENT_TYPES[0])($diff);
}

function getContents(string $parser, string ...$paths): array
{
    return array_map(
        function ($path) use ($parser) {
            $realPath = getPath($path);
            isReadable($realPath);
            return getParser($parser)(getContent($realPath));
        },
        $paths
    );
}
