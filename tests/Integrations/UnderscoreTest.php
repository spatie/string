<?php

namespace Spatie\String\Test\Integrations;

class UnderscoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_use_underscores_methods()
    {
        $this->assertEquals('i-am-a-slug', (string) string('i am a slug')->slugify());
    }

    /**
     * @test
     */
    public function it_can_use_underscore_methods_that_have_a_string_as_input()
    {
        $this->assertEquals('tobeornottobe', (string) string('tobe')->append('ornottobe'));
    }

    /**
     * @test
     */
    public function it_can_use_underscore_methods_that_do_not_need_a_string_as_input()
    {
        $this->assertEquals(20, strlen((string) string()->random(20)));
    }

    /**
     * @test
     */
    public function it_can_use_underscore_methods_that_do_not_return_a_string()
    {
        $this->assertTrue(string('freek@spatie.be')->isEmail());
        $this->assertFalse(string('noemail')->isEmail());
    }

    /**
     * @test
     */
    public function it_can_chain_with_underscore_methods()
    {
        $this->assertEquals('I-AM-A-SLUG', (string) string('i am a slug')->slugify()->toUpper());
    }
}
