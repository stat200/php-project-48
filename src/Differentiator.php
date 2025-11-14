<?php

namespace Differentiator;

use Hexlet\Code\exceptions\AggregateValidationException;

use function GenDiff\Ast\getTemplate;
use function GenDiff\Ast\makeAst;
use function GenDiff\Configs\getParam;
use function GenDiff\Infrastructure\IO\FileSystem\getMimes;
use function GenDiff\Formater\getFormater;
use function GenDiff\Services\getPaths;
use function Gendiff\Parsers\getParser;
use function GenDiff\Validators\validateContentTypes;
use function GenDiff\Configs\getContentFormat;
use function GenDiff\Services\getContents;

/**
 * @throws \Exception
 */
function genDiff(string ...$pathsToFiles): string
{
    $mimes = getMimes($pathsToFiles);
    $validatedResult = validateContentTypes($mimes);
    if (!empty($validatedResult['errors'])) {
        throw new AggregateValidationException($validatedResult['errors']);
    }

    $contentType = getContentFormat($mimes[0]);
    $parserType = getParam('parser', $contentType, null);
    $parser = getParser($parserType);
    $pathsToFiles = getPaths($pathsToFiles);
    $contents = getContents($parser, $pathsToFiles);
    [$content1, $content2] = $contents;

    $template = getTemplate(gettype($content1));
    $ast = makeAst($template, $content1, $content2);
    $formaterType = getParam('formatter', 'stylish');
    $formater = getFormater($formaterType);
    return $formater($ast);
}
