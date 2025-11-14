<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use function GenDiff\Helper\stringifyValue;

class HelperTest extends TestCase
{
    public function testStringifyValue(): void
    {
        $result = stringifyValue(null);
        $this->assertEquals('null', $result);

        $result = stringifyValue(true);
        $this->assertEquals('true', $result);

        $result = stringifyValue(false);
        $this->assertEquals('false', $result);
    }
}