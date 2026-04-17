<?php

namespace Spatie\String\Test\Functions;

use PHPUnit\Framework\TestCase;
use Spatie\String\Str;

class PrefixTest extends TestCase
{
    /** @test */
    public function it_can_prefix_a_string()
    {
        $this->assertEquals('hello world', (string) string('world')->prefix('hello '));
    }

    /** @test */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(Str::class, string('world')->prefix('hello '));
    }
}
