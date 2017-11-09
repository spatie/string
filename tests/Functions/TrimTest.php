<?php

namespace Spatie\String\Test\Functions;

use PHPUnit\Framework\TestCase;

class TrimTest extends TestCase
{
    /** @test */
    public function it_trims_default_characters()
    {
        $this->assertEquals('foo', (string) string('  foo ')->trim());
    }

    /** @test */
    public function it_trims_custom_characters()
    {
        $this->assertEquals('foo', (string) string('/foo')->trim('/'));
    }

    /** @test */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string(' foo ')->trim());
    }
}
