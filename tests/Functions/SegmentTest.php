<?php

namespace Spatie\String\Test\Functions;

class SegmentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_retrieves_a_segment()
    {
        $this->assertEquals('foo', (string) string('foo/bar/baz')->segment('/', 0));
        $this->assertEquals('bar', (string) string('foo/bar/baz')->segment('/', 1));
        $this->assertEquals('baz', (string) string('foo/bar/baz')->segment('/', 2));
        $this->assertEquals('',    (string) string('foo/bar/baz')->segment('/', 3));
    }

    /**
     * @test
     */
    public function it_accepts_empty_strings()
    {
        $this->assertEquals('', (string) string('')->segment('/', 0));
    }

    /**
     * @test
     */
    public function it_retrieves_a_segment_in_reverse()
    {
        $this->assertEquals('baz', (string) string('foo/bar/baz')->segment('/', -1));
        $this->assertEquals('bar', (string) string('foo/bar/baz')->segment('/', -2));
        $this->assertEquals('foo', (string) string('foo/bar/baz')->segment('/', -3));
        $this->assertEquals('',    (string) string('foo/bar/baz')->segment('/', -4));
    }

    /**
     * @test
     */
    public function it_retrieves_the_first_segment()
    {
        $this->assertEquals('foo', (string) string('foo/bar/baz')->firstSegment('/'));
    }

    /**
     * @test
     */
    public function it_retrieves_the_last_segment()
    {
        $this->assertEquals('baz', (string) string('foo/bar/baz')->lastSegment('/'));
    }

    /**
     * @test
     */
    public function it_pops_the_last_segment()
    {
        $this->assertEquals('foo/bar', (string) string('foo/bar/baz')->pop('/'));
    }

    /**
     * @test
     */
    public function it_is_chainable()
    {
        $this->assertInstanceOf(\Spatie\String\Str::class, string('foo/bar/baz')->segment('/', 0));
        $this->assertInstanceOf(\Spatie\String\Str::class, string('foo/bar/baz')->firstSegment('/'));
        $this->assertInstanceOf(\Spatie\String\Str::class, string('foo/bar/baz')->lastSegment('/'));
        $this->assertInstanceOf(\Spatie\String\Str::class, string('foo/bar/baz')->pop('/'));
    }
}
