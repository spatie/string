<?php

namespace Spatie\String\Integrations;

use Spatie\String\Str;

class Underscore
{
    protected array $underscoreMethods =
        [
            //name, firstArgumentIsString, returnsAString
            'accord' => [false, true],
            'random' => [false, true],
            'quickRandom' => [false, true],
            'randomStrings' => [false, true],
            'endsWith' => [true, false],
            'isIp' => [true, false],
            'isEmail' => [true, false],
            'isUrl' => [true, false],
            'startsWith' => [true, false],
            'find' => [true, false],
            'slice' => [true, false],
            'sliceFrom' => [true, true],
            'sliceTo' => [true, true],
            'baseClass' => [true, true],
            'prepend' => [true, true],
            'append' => [true, true],
            'limit' => [true, true],
            'remove' => [true, true],
            'replace' => [true, true],
            'toggle' => [true, true],
            'slugify' => [true, true],
            'explode' => [true, false],
            'lower' => [true, true],
            'plural' => [true, true],
            'singular' => [true, true],
            'upper' => [true, true],
            'title' => [true, true],
            'words' => [true, true],
            'toPascalCase' => [true, true],
            'toSnakeCase' => [true, true],
            'toCamelCase' => [true, true],
        ];

    /**
     * @param \Spatie\String\Str $string
     * @param string             $method
     * @param array              $args
     *
     * @return mixed|\Spatie\String\Str
     */
    public function call(Str $string, string $method, array $args)
    {
        if ($this->methodUsesStringAsFirstArgument($method)) {
            array_unshift($args, (string) $string);
        }

        $underscoreResult = call_user_func_array(['Underscore\Types\Strings', $method], $args);

        if ($this->methodReturnsAString($method)) {
            return new Str($underscoreResult);
        }

        return $underscoreResult;
    }

    public function isSupportedMethod(string $method): bool
    {
        return array_key_exists($method, $this->underscoreMethods);
    }

    public function methodUsesStringAsFirstArgument(string $method): bool
    {
        return $this->isSupportedMethod($method) ? $this->underscoreMethods[$method][0] : false;
    }

    public function methodReturnsAString(string $method): bool
    {
        return $this->isSupportedMethod($method) ? $this->underscoreMethods[$method][1] : false;
    }
}
