<?php

namespace GenDiff\Ast;

const STATUSES = [
    'changed' => 'CHANGED',
    'deleted' => 'DELETED',
    'added' => 'ADDED'
];

function getTemplate(string $type): callable
{
    return templates()[$type];
}

function templates(): array
{
    return [
        'array' =>
            function ($item, string $key, ?array $children, ?string $status = null, ?bool $isOldFlag = null) {
                return [
                    'name' => $key,
                    'expr' => $item,
                    'isOld' => $isOldFlag,
                    'status' => $status,
                    'children' => $children,
                ];
            },
    ];
}

function makeAst(callable $template, array $array1, array $array2): array
{
    $acc = [];
    $keys = array_keys(array_merge($array1, $array2));
    sort($keys, SORT_STRING);
    foreach ($keys as $key) {
        if (array_key_exists($key, $array1) && array_key_exists($key, $array2)) {
            if (is_array($array1[$key]) && is_array($array2[$key])) {
                $diff = makeAst($template, $array1[$key], $array2[$key]);
                $acc[] = $template(null, $key, $diff);
                continue;
            }
            if ($array1[$key] === $array2[$key]) {
                $acc[] = $template($array1[$key], $key, null);
            } else {
                $acc[] = $template($array1[$key], $key, null, STATUSES['changed'], true);
                $acc[] = $template($array2[$key], $key, null, STATUSES['changed'], false);
            }
        } elseif (array_key_exists($key, $array1)) {
            $acc[] = $template($array1[$key], $key, null, STATUSES['deleted']);
        } else {
            $acc[] = $template($array2[$key], $key, null, STATUSES['added']);
        }
    }
    return $acc;
}
