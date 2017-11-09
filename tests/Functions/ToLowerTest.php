<?php

namespace Spatie\String\Test\Functions;

use PHPUnit\Framework\TestCase;

class ToLowerTest extends TestCase
{
    /** @test */
    public function it_can_convert_a_string_to_lowercase()
    {
        $this->assertEquals('lowercase', (string) string('LOWERCASE')->toLower());
    }

    /** @test */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('test')->toLower());
    }
}
