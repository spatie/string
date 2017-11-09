<?php

namespace Spatie\String\Test\Functions;

use PHPUnit\Framework\TestCase;

class ContainsTest extends TestCase
{
    /** @test */
    public function it_is_an_alias_for_find()
    {
        $this->assertEquals(string('hello world')->contains('world'), string('hello world')->find('world'));
        $this->assertEquals(string('hello world')->contains('belgium'), string('hello world')->find('belgium'));
    }
}
