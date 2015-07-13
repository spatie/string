<?php

namespace Spatie\String\Test\Functions;

class PrefixTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_prefix_a_string()
    {
        $this->assertEquals('hello world', (string) string('world')->prefix('hello '));
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('world')->prefix('hello '));
    }
}
