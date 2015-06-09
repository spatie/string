<?php

use Spatie\String\String;

/**
 * Poor man's string factory.
 *
 * @param string $string
 *
 * @return \Spatie\String\String
 */
function string($string = '')
{
    return new String($string);
}
