<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\Encoder\encoders;
use function GenDiff\Encoder\getEncoder;

class EncoderTest extends TestCase
{
    public function testEncodeToJsonException(): void
    {
        $this->expectException(\JsonException::class);
        getEncoder('json')("\xB1\x31");
    }
}
