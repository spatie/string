<?php

namespace Spatie\String\Test\Functions;

class ToUpperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_convert_a_string_to_uppercase()
    {
        $this->assertEquals('UPPERCASE', (string) string('uppercase')->toUpper());
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('test')->toUpper());
    }
}
