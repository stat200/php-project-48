<?php

namespace GenDiff\Ast;

const STATUSES = [
    'changed' => 'CHANGED',
    'deleted' => 'DELETED',
    'added' => 'ADDED'
];

function templates(): callable
{
    return function (string $key, $item, ?string $status, ?bool $isOldFlag, string $path, ?array $children) {
        return [
            'name' => $key,
            'expr' => $item,
            'status' => $status,
            'isOld' => $isOldFlag,
            'path' => $path,
            'children' => $children,
        ];
    };
}

function makeAst(array $arr1, array $arr2, callable $template, string $parentPath = ''): array
{
    $keys = array_unique(array_merge(
        array_keys($arr1),
        array_keys($arr2)
    ));
    sort($keys, SORT_STRING);
    $ast = [];
    foreach ($keys as $key) {
        $currentPath = $parentPath ? "{$parentPath}.{$key}" : $key;
        if (!array_key_exists($key, $arr2)) {
            $ast[] = $template($key, $arr1[$key], STATUSES['deleted'], null, $currentPath, null);
        } elseif (!array_key_exists($key, $arr1)) {
            $ast[] = $template($key, $arr2[$key], STATUSES['added'], null, $currentPath, null);
        } elseif (is_array($arr1[$key]) && is_array($arr2[$key])) {
            $diff = makeAst($arr1[$key], $arr2[$key], $template, $currentPath);
            $ast[] = $template($key, null, null, null, $currentPath, $diff);
        } elseif ($arr1[$key] !== $arr2[$key]) {
            $ast[] = $template($key, $arr1[$key], STATUSES['changed'], true, $currentPath, null);
            $ast[] = $template($key, $arr2[$key], STATUSES['changed'], false, $currentPath, null);
        } else {
            $ast[] = $template($key, $arr1[$key], null, null, $currentPath, null);
        }
    }
    return $ast;
}
