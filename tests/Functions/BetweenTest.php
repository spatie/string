<?php

namespace Spatie\String\Test\Functions;

class BetweenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_can_return_the_string_between_two_string()
    {
        $this->assertEquals('Middle', (string) string('StartMiddleEnd')->between('Start', 'End'));
    }

    /**
     * @test
     */
    public function it_returns_an_empty_string_when_the_start_is_not_found()
    {
        $this->assertEquals('', (string) string('MiddleEnd')->between('Start', 'End'));
    }

    /**
     * @test
     */
    public function it_returns_an_empty_string_when_the_end_is_not_found()
    {
        $this->assertEquals('', (string) string('StartMiddle')->between('Start', 'End'));
    }

    /**
     * @test
     */
    public function it_returns_an_empty_string_when_start_and_end_are_not_in_the_right_order()
    {
        $this->assertEquals('', (string) string('StartMiddleEnd')->between('End', 'Start'));
    }

    /**
     * @test
     */
    public function it_returns_an_the_middle_even_if_start_and_end_are_the_same_string()
    {
        $this->assertEquals('Middle', (string) string('StartMiddleStart')->between('Start', 'Start'));
    }

    /**
     * @test
     */
    public function it_returns_everything_after_the_start_if_end_is_an_emptyString()
    {
        $this->assertEquals('MiddleEnd', (string) string('StartMiddleEnd')->between('Start', ''));
    }

    /**
     * @test
     */
    public function it_returns_everything_until_the_end_if_start_is_an_emptyString()
    {
        $this->assertEquals('StartMiddle', (string) string('StartMiddleEnd')->between('', 'End'));
    }

    /**
     * @test
     */
    public function it_returns_everything_if_both_start_and_end_are_empty()
    {
        $this->assertEquals((string) string('StartMiddleEnd')->between('', ''), 'StartMiddleEnd');
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('test')->between('', ''));
    }
}
