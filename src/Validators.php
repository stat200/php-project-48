<?php

namespace GenDiff\Validators;

use InvalidArgumentException;

use function GenDiff\Utils\normalizeContentType;

/**
 * @throws InvalidArgumentException
 */
function validateContentTypes(array $mimes): void
{
    [$mime1, $mime2] = $mimes;
    $allowedTypes = [
        'application/json',
        'text/plain',
        'text/yaml',
    ];

    $mime1 = normalizeContentType($mime1);
    $mime2   = normalizeContentType($mime2);

    if (!in_array($mime1, $allowedTypes, true)) {
        throw new InvalidArgumentException(
            "Unsupported content type: {$mime1}"
        );
    }

    if (!in_array($mime2, $allowedTypes, true)) {
        throw new InvalidArgumentException(
            "Unsupported content type: {$mime2}"
        );
    }

    if ($mime1 !== $mime2) {
        throw new InvalidArgumentException(
            "Content-Type mismatch: {$mime1} vs {$mime2}"
        );
    }
}
