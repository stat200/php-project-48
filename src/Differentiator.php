<?php

namespace Differentiator;

use GenDiff\Configs\ParamType;

use function GenDiff\Ast\makeAst;
use function GenDiff\Ast\templates;
use function GenDiff\Factories\getFormatter;
use function GenDiff\Configs\getParam;
use function GenDiff\Services\getPaths;
use function Gendiff\Factories\getParser;
use function GenDiff\Services\getContents;
use function GenDiff\Utils\getMimes;
use function GenDiff\Utils\getParserTypeByMime;
use function GenDiff\Validators\validateContentTypes;

/**
 * @throws \Exception
 */
function genDiff(string $pathToFile1, string $pathToFile2, ?string $formatterType = null,): string
{
    $pathsToFiles = [$pathToFile1, $pathToFile2];
    $paths = getPaths($pathsToFiles);
    $mimes = getMimes($paths);
    validateContentTypes($mimes);
    $mimeParserType = getParserTypeByMime($mimes[0]);
    $parserType = getParam(ParamType::Parser, $mimeParserType);
    $parser = getParser($parserType);
    $contents = getContents($parser, $paths);
    [$content1, $content2] = $contents;
    $template = templates();
    $ast = makeAst($content1, $content2, $template);
    $formatterType = getParam(ParamType::Formatter, $formatterType);
    $formatter = getFormatter($formatterType);
    return $formatter($ast);
}
