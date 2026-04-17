<?php

namespace Spatie\String\Test\Functions;

use PHPUnit\Framework\TestCase;
use Spatie\String\Str;

class SuffixTest extends TestCase
{
    /** @test */
    public function it_can_suffix_a_string()
    {
        $this->assertEquals('hello world', (string) string('hello')->suffix(' world'));
    }

    /** @test */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(Str::class, string('hello')->suffix(' world'));
    }
}
