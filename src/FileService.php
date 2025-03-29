<?php

namespace GenDiff\FileService;

function isReadable(string $file): bool
{
    return file_exists($file) && is_readable($file);
}

/**
 * @throws \Exception
 */
function getContents(string $file): string
{
    $contents = '';
    if (isReadable($file)) {
        $contents = file_get_contents($file);
    }
    if ($contents === false) {
        throw new \Exception('can\'t read content from file');
    }
    return $contents;
}
