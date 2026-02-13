<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;

use function GenDiff\Services\formattersServices;

class FormattersServicesTest extends TestCase
{
    public function testArrayHasKnownInAdvancedKeys(): void
    {
        $keys = [
            'makeChangeSet'
        ];

        $this->assertEqualsCanonicalizing($keys, array_keys(formattersServices([])));
    }
    public function testEveryItemReturnClosure(): void
    {
        foreach (formattersServices([]) as $item) {
            $this->assertInstanceOf(\Closure::class, $item);
        }
    }
}
