<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use function Config\getParams;

class ParamsTest extends TestCase
{
    public function testGetParams(): void
    {
        $params = getParams();
        $this->assertIsCallable($params);
    }
}
