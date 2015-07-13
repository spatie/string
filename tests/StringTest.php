<?php

namespace Spatie\String\Test;

class StringTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function the_string_function_returns_a_string_instance()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('test'));
    }

    /**
     * @test
     */
    public function it_can_handle_an_empty_string()
    {
        $this->assertEquals('', (string) string(''));
    }

    /**
     * @test
     */
    public function it_can_handle_a_non_empty_string()
    {
        $this->assertEquals('test', (string) string('test'));
    }

    /**
     * @test
     */
    public function it_can_be_concatinated_with_a_string()
    {
        $this->assertEquals('testconcatination', string('test').'concatination');
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $result = string('StartMiddleEnd')
            ->between('Start', 'End')
            ->toUpper();

        $this->assertEquals('MIDDLE', (string) $result);
    }

    /**
     * @test
     */
    public function it_raises_an_exception_when_an_undefined_method_is_called()
    {
        $this->setExpectedException('Spatie\String\Exceptions\UnknownFunctionException');

        string('test')->unknownFunction('hi');
    }

    /**
     * @test
     */
    public function it_can_make_a_string_by_using_an_offset()
    {
        $this->assertEquals('s', string('string')[0]);
        $this->assertEquals('t', string('string')[1]);
        $this->assertEquals('g', string('string')[-1]);
    }

    /**
     * @test
     */
    public function it_returns_an_empty_string_when_using_an_invalid_offset()
    {
        $this->assertEquals('', string('string')[1000]);
    }

    /**
     * @test
     */
    public function it_can_still_chain_after_using_an_offset()
    {
        $this->assertEquals('S', string('string')[0]->toUpper());
        $this->assertEquals('T', string('string')->toUpper()[1]);
    }

    /**
     * @test
     */
    public function it_can_change_a_string_by_using_an_offset()
    {
        $string = string('string');
        $string[0] = 'X';
        $this->assertEquals('Xtring', (string) $string);
    }

    /**
     * @test
     */
    public function it_can_determine_if_an_offset_is_set()
    {
        $string = string('s');
        $this->assertTrue(isset($string[0]));
        $this->assertFalse(isset($string[1]));
    }

    /**
     * @test
     */
    public function it_raises_an_exception_when_trying_to_unset_via_an_offset()
    {
        $string = string('string');
        $this->setExpectedException('Spatie\String\Exceptions\UnsetOffsetException');
        unset($string[0]);
    }
}
