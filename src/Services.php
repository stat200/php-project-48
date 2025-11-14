<?php

namespace GenDiff\Services;

use function GenDiff\Infrastructure\IO\FileSystem\getContent;
use function GenDiff\Infrastructure\IO\FileSystem\getPath;
use function GenDiff\Infrastructure\IO\FileSystem\isReadable;

function getContents(callable $parser, array $paths): array
{
    return array_map(
        function ($path) use ($parser) {
            $content = getContent($path);
            return $parser($content);
        },
        $paths
    );
}

/**
 * @throws \Exception
 */
function getPaths(array $paths): array
{
    return array_map(
        function ($path) {
            $realPath = getPath($path);
            isReadable($realPath);
            return $realPath;
        },
        $paths
    );
}
