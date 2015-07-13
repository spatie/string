<?php

namespace Spatie\String\Test\Functions;

class ConcatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_concatenate_a_string()
    {
        $this->assertEquals('hello world', (string) string('hello')->concat(' world'));
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('hello')->concat(' world'));
    }
}
