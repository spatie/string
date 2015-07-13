<?php

namespace Spatie\String\Test\Functions;

class SuffixTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_suffix_a_string()
    {
        $this->assertEquals('hello world', (string) string('hello')->suffix(' world'));
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('hello')->suffix(' world'));
    }
}
