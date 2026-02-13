<?php

namespace GenDiff\Services;

use function GenDiff\Utils\isReadable;
use function GenDiff\Utils\getPath;
use function GenDiff\Utils\getContent;

enum ChangeSetKeys: string
{
    case OLD = 'oldElem';
    case NEW = 'newElem';
    case CURRENT = 'currentElem';
}

/**
 * @throws \Exception
 */
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

function formattersServices(array $ast): array
{
    return [
        'makeChangeSet' => function () use ($ast) {
            $set = [];

            $walker = function ($node) use (&$walker, &$set) {
                $path = $node['path'];

                $set[$path] ??=  [
                    ChangeSetKeys::OLD->value => null,
                    ChangeSetKeys::NEW->value => null,
                    ChangeSetKeys::CURRENT->value => null,
                ];

                if ($node['isOld'] === true) {
                    $set[$path][ChangeSetKeys::OLD->value] = $node;
                } elseif ($node['isOld'] === false) {
                    $set[$path][ChangeSetKeys::NEW->value] = $node;
                } else {
                    $set[$path][ChangeSetKeys::CURRENT->value] = $node;
                }

                if (!empty($node['children'])) {
                    foreach ($node['children'] as $child) {
                        $walker($child);
                    }
                }
            };

            foreach ($ast as $node) {
                $walker($node);
            }

            return $set;
        },
    ];
}
