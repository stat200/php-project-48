<?php

namespace Differentiator;

use function Gendiff\Parser\parseJson;
use function GenDiff\FileService\getContents;

/**
 * @throws \JsonException
 * @throws \Exception
 */
function getDifference($file1, $file2): void
{
    $path1 = realpath($file1);
    $path2 = realpath($file2);
    $content1 = parseJson(getContents($path1));
    $content2 = parseJson(getContents($path2));
    var_dump($content1);
    var_dump($content2);
}

