<?php

namespace GenDiff\Utils;

use Exception;
use InvalidArgumentException;
use OutOfRangeException;
use RuntimeException;

/**
 * @throws Exception
 */
function isReadable(string $file): void
{
    if (is_readable($file) === false) {
        throw new Exception('file is not readable or doesn\'t exist: ' . $file);
    }
}

function validateFile(string $file): void
{
    if (!is_file($file) || !is_readable($file)) {
        throw new RuntimeException("File '{$file}' is not readable");
    }
}

function getContent(string $file): string
{
    validateFile($file);
    $content = file_get_contents($file);
    if ($content === false) {
        throw new RuntimeException("Can't read content from file '{$file}'");
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
        throw new Exception("Can't resolve real path for '{$file}'");
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
        throw new \OutOfRangeException('Exactly 2 paths are required');
    }
    return array_map(function ($path) {
        if (!is_file($path)) {
            throw new RuntimeException("File '{$path}' does not exist");
        }

        $contentType = mime_content_type($path);
        if ($contentType === false) {
            throw new RuntimeException("Can't determine mime type for '{$path}'");
        }
        return strtolower(trim($contentType));
    }, $paths);
}
