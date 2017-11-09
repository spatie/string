<?php

namespace Spatie\String\Test\Functions;

use PHPUnit\Framework\TestCase;

class ToUpperTest extends TestCase
{
    /** @test */
    public function it_can_convert_a_string_to_uppercase()
    {
        $this->assertEquals('UPPERCASE', (string) string('uppercase')->toUpper());
    }

    /** @test */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('test')->toUpper());
    }
}
