<?php

use Spatie\String\Str;

function string(mixed $string = ''): Str
{
    return new Str($string);
}
