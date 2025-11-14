<?php

namespace GenDiff\Infrastructure\IO\FileSystem;

use Exception;
use InvalidArgumentException;
use OutOfRangeException;

/**
 * @throws Exception
 */
function isReadable(string $file): void
{
    if (is_readable($file) === false) {
        throw new Exception('file is not readable or doesn\'t exist: ' . $file);
    }
}

/**
 * @throws Exception
 */
function getContent(string $file): string
{
    $content = @file_get_contents($file);
    if ((bool) $content === false) {
        throw new Exception('can\'t read content from file');
    }
    return $content;
}

/**
 * @throws Exception
 */
function getPath(string $file): string
{
    $path = realpath($file);
    if ($path === false) {
        throw new Exception('can\'t create path');
    }
    return $path;
}

/**
 * @throws OutOfRangeException
 * @throws InvalidArgumentException
 *
 */
function getMimes(array $paths): array
{
    if (count($paths) !== 2) {
        throw new \OutOfRangeException('count paths do not match');
    }
    return array_map(function ($path) {

        $contentType = mime_content_type($path);
        if ($contentType === false) {
            throw new \InvalidArgumentException('can\'t determine content type');
        }
        return strtolower(trim($contentType));
    }, $paths);
}
