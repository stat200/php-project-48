<?php

namespace GenDiff\FileService;

const FILES_TYPES = [
    'json' => 'json',
    'yaml' => 'yaml',
    'yml' => 'yaml',
];

/**
 * @throws \Exception
 */
function isReadable(string $file): void
{
    if (is_readable($file) === false) {
        throw new \Exception('file is not readable or doesn\'t exist: ' . $file);
    }
}

/**
 * @throws \Exception
 */
function getContent(string $file): string
{
    $contents = @file_get_contents($file);
    if ((bool) $contents === false) {
        throw new \Exception('can\'t read content from file');
    }
    return $contents;
}

/**
 * @throws \Exception
 */
function getPath(string $file): string
{
    $path = realpath($file);
    if ($path === false) {
        throw new \Exception('can\'t create path');
    }
    return $path;
}
function getContentType(string $pathToFile): string
{
    $fileType = pathinfo($pathToFile, PATHINFO_EXTENSION);
    if (!array_key_exists($fileType, FILES_TYPES)) {
        throw new \Exception('file type is not supported');
    }
    return FILES_TYPES[$fileType];
}
