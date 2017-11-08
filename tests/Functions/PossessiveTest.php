<?php

namespace Spatie\String\Test\Functions;

class PossessiveTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_create_the_possessive_version_of_a_string()
    {
        $this->assertEquals('Bob\'s', (string) string('Bob')->possessive());
        $this->assertEquals('Charles\'', (string) string('Charles')->possessive());
    }

    /** @test */
    public function it_can_handle_an_empty_string()
    {
        $this->assertEquals('', (string) string('')->possessive());
    }

    /** @test */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('Bob')->possessive());
    }

    /** @test */
    public function it_can_handle_its_edge_case()
    {
        $this->assertEquals('its', (string) string('it')->possessive());
    }
}
