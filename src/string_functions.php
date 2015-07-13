<?php

use Spatie\String\Str;

/**
 * Poor man's string factory.
 *
 * @param string $string
 *
 * @return \Spatie\String\Str
 */
function string($string = '')
{
    return new Str($string);
}
