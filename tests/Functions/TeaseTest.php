<?php

namespace Spatie\String\Test\Functions;

class TeaseTest extends \PHPUnit_Framework_TestCase
{
    protected $longText = 'Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book that comes with it: the most popular gun in American crime.';

    protected $shortText = 'This is a short sentence';

    protected $spacedText = 'a   whole  lot   of       spaces';

    /**
     * @test
     */
    public function it_can_shorten_a_text_in_a_beautiful_way()
    {
        $this->assertEquals('Now that there is the Tec-9, a crappy spray gun from South Miami. This gun is advertised as the most popular gun in American crime. Do you believe that shit? It actually says that in the little book...', (string) string($this->longText)->tease());
    }

    /**
     * @test
     */
    public function it_can_shorten_a_text_in_a_beautiful_way_to_a_specified_length()
    {
        $this->assertEquals('Now that...', (string) string($this->longText)->tease(10));
    }

    /**
     * @test
     */
    public function it_can_shorten_a_text_in_a_beautiful_way_to_a_specified_length_with_a_custom_moreTextIndicator()
    {
        $this->assertEquals('Now that!', (string) string($this->longText)->tease(10, '!'));
    }

    /**
     * @test
     */
    public function it_will_return_the_original_text_if_the_orignal_text_is_shorter_than_the_specified_length()
    {
        $this->assertEquals($this->shortText, (string) string($this->shortText)->tease(200));
    }

    /**
     * @test
     */
    public function it_removes_html_from_the_original_text()
    {
        $this->assertEquals($this->shortText, (string) string('<b>'.$this->shortText.'</b>')->tease(200));
    }

    /**
     * @test
     */
    public function it_trims_the_original_text()
    {
        $this->assertEquals($this->shortText, (string) string(' '.$this->shortText.' ')->tease(200));
    }

    /**
     * @test
     */
    public function it_removes_double_spaces_from_the_original_text()
    {
        $this->assertEquals('a whole lot of spaces', (string) string('<b>'.$this->spacedText.'</b>')->tease(200));
    }

    /**
     * @test
     */
    public function teasing_an_empty_string_returns_an_empty_string()
    {
        $this->assertEquals('lowercase', (string) string('LOWERCASE')->toLower());
    }

    /**
     * @test
     */
    public function it_return_an_empty_string_if_after_trimming_everything_is_cleaned_up()
    {
        $this->assertEquals('', (string) string('    ')->tease(200));
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('test')->tease());
    }
}
