<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use function GenDiff\Validators\validateContentTypes;

class ValidatorsTest extends TestCase
{
    public function testValidateContentTypes(): void
    {
        $result = validateContentTypes(['text/html', 'image/png']);
        $this->assertFalse($result['ok']);
        $this->assertNotEmpty($result['errors']);

        $result = validateContentTypes(['application/json', 'text/plain']);
        $this->assertFalse($result['ok']);
        $this->assertNotEmpty($result['errors']);

        $result = validateContentTypes(['application/json', 'application/json']);
        $this->assertTrue($result['ok']);
        $this->assertEmpty($result['errors']);
    }
}
