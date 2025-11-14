<?php

namespace GenDiff\Validators;

function validateContentTypes(array $types): array
{
    $allowedTypes = ['application/json', 'text/plain', 'text/yaml'];
    [$type1, $type2] = $types;
    $errors = [];

    if (!in_array($type1, $allowedTypes, true)) {
        $errors[] = "Unsupported type: {$type1}";
    }

    if (!in_array($type2, $allowedTypes, true)) {
        $errors[] = "Unsupported type: {$type2}";
    }

    if ($type1 !== $type2) {
        $errors[] = "Types mismatch: {$type1} vs {$type2}";
    }

    return [
        'ok'    => $errors === [],
        'errors' => $errors,
    ];
}
