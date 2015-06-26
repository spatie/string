<?php

namespace Spatie\String\Test\Functions;

class ReplaceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_replace_string_by_another_string()
    {
        $this->assertEquals('hello, i am Rogier', (string) string('hello, i am Willem')->replace('Willem', 'Rogier'));
    }

    /**
     * @test
     */
    public function it_can_replace_string_by_another_string_even_if_the_string_occurs_multiple_times()
    {
        $this->assertEquals('Rogier and Rogier', (string) string('Willem and Willem')->replace('Willem', 'Rogier'));
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $this->assertInstanceOf('Spatie\String\String', string('hello, i am Willem')->replace('Willem', 'Rogier'));
    }
}
