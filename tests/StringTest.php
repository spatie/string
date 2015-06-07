<?php

namespace Spatie\String\Test;

class StringTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function the_string_function_returns_a_string_instance()
    {
        $this->assertInstanceOf('Spatie\String\String', string('test'));
    }

    /**
     * @test
     */
    public function it_can_handle_an_empty_string()
    {
        $this->assertEquals('', (string)string(''));
    }

    /**
     * @test
     */
    public function it_can_handle_a_non_empty_string()
    {
        $this->assertEquals('test', (string)string('test'));
    }

    /**
     * @test
     */
    public function it_can_be_concatinated_with_a_string()
    {
        $this->assertEquals('testconcatination', string('test') . 'concatination');
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $result = string('StartMiddleEnd')
            ->between('Start', 'End')
            ->toUpper();

        $this->assertEquals('MIDDLE', (string)$result);
    }

    /**
     * @test
     */
    public function it_raises_an_exception_when_an_undefined_method_is_called()
    {
        $this->setExpectedException('Spatie\String\Exceptions\UnknownFunctionException');

        string('test')->unknownFunction('hi');
    }

}
