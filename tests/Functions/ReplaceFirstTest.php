<?php

namespace Spatie\String\Test\Functions;

class ReplaceFirstTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_replaces_the_first_occurence_of_a_string_by_another_string()
    {
        $sentence = 'A good thing is not a good thing.';
        $expected = 'A bad thing is not a good thing.';

        $this->assertEquals($expected, (string) string($sentence)->replaceFirst('good', 'bad'));
    }

    /** @test */
    public function it_returns_the_original_string_if_the_search_string_is_not_present()
    {
        $sentence = 'A good thing is not a bad thing.';

        $this->assertEquals($sentence, (string) string($sentence)->replaceFirst('beautiful', 'bad'));
    }

    /** @test */
    public function it_returns_the_original_string_if_search_string_is_empty()
    {
        $sentence = 'A good thing is not a bad thing.';

        $this->assertEquals($sentence, (string) string($sentence)->replaceFirst('', 'bad'));
    }

    /** @test */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('test')->replaceFirst('search', 'replace'));
    }
}
