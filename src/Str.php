<?php

namespace Spatie\String;

use ArrayAccess;
use Spatie\String\Exceptions\ErrorCreatingString;
use Spatie\String\Exceptions\UnknownFunction;
use Spatie\String\Exceptions\UnsetOffset;
use Spatie\String\Integrations\Underscore;

/**
 * Magic methods provided by underscore are documented here.
 *
 * @see \Underscore\Methods\StringsMethods
 *
 * @method \Spatie\String\Str accord($count, $many, $one, $zero = null)
 * @method \Spatie\String\Str random($length = 16)
 * @method \Spatie\String\Str quickRandom($length = 16)
 * @method randomStrings($words, $length = 10)
 * @method bool endsWith($needles)
 * @method bool isIp()
 * @method bool isEmail()
 * @method bool isUrl()
 * @method bool startsWith()
 * @method bool find($needle, $caseSensitive = false, $absolute = false)
 * @method array slice($slice)
 * @method \Spatie\String\Str sliceFrom($slice)
 * @method \Spatie\String\Str sliceTo($slice)
 * @method \Spatie\String\Str baseClass()
 * @method \Spatie\String\Str prepend($with)
 * @method \Spatie\String\Str append($with)
 * @method \Spatie\String\Str limit($limit = 100, $end = '...')
 * @method \Spatie\String\Str remove($remove)
 * @method \Spatie\String\Str replace($replace, $with)
 * @method \Spatie\String\Str toggle($first, $second, $loose = false)
 * @method \Spatie\String\Str slugify($separator = '-')
 * @method array explode($with, $limit = null)
 * @method \Spatie\String\Str lower()
 * @method \Spatie\String\Str plural()
 * @method \Spatie\String\Str singular()
 * @method \Spatie\String\Str upper()
 * @method \Spatie\String\Str title()
 * @method \Spatie\String\Str words($words = 100, $end = '...')
 * @method \Spatie\String\Str toPascalCase()
 * @method \Spatie\String\Str toSnakeCase()
 * @method \Spatie\String\Str toCamelCase()
 */
class Str implements ArrayAccess
{
    protected string $string;

    public function __construct(mixed $string = '')
    {
        if (is_array($string)) {
            throw new ErrorCreatingString('Can\'t create string from an array');
        }

        if (is_object($string) && ! method_exists($string, '__toString')) {
            throw new ErrorCreatingString(
                'Can\'t create string from an object that doesn\'t implement __toString'
            );
        }

        $this->string = (string) $string;
    }

    public function __toString(): string
    {
        return $this->string;
    }

    /**
     * Get the string between the given start and end.
     *
     * @param $start
     * @param $end
     *
     * @return \Spatie\String\Str
     */
    public function between(string $start, string $end): static
    {
        if ($start == '' && $end == '') {
            return $this;
        }

        if ($start != '' && ! str_contains($this->string, $start)) {
            return new static();
        }

        if ($end != '' && ! str_contains($this->string, $end)) {
            return new static();
        }

        if ($start == '') {
            return new static(substr($this->string, 0, strpos($this->string, $end)));
        }

        if ($end == '') {
            return new static(substr($this->string, strpos($this->string, $start) + strlen($start)));
        }

        $stringWithoutStart = explode($start, $this->string)[1];

        $middle = explode($end, $stringWithoutStart)[0];

        return new static($middle);
    }

    public function toUpper(): static
    {
        return new static(strtoupper($this->string));
    }

    public function toLower(): static
    {
        return new static(strtolower($this->string));
    }

    /**
     * Shortens a string in a pretty way. It will clean it by trimming
     * it, remove all double spaces and html. If the string is then still
     * longer than the specified $length it will be shortened. The end
     * of the string is always a full word concatinated with the
     * specified moreTextIndicator.
     *
     * @param int    $length
     * @param string $moreTextIndicator
     *
     * @return \Spatie\String\Str
     */
    public function tease(int $length = 200, string $moreTextIndicator = '...'): static
    {
        $sanitizedString = $this->sanitizeForTease($this->string);

        if (strlen($sanitizedString) === 0) {
            return new static();
        }

        if (strlen($sanitizedString) <= $length) {
            return new static($sanitizedString);
        }

        $ww = wordwrap($sanitizedString, $length, "\n");
        $shortenedString = substr($ww, 0, strpos($ww, "\n")).$moreTextIndicator;

        return new static($shortenedString);
    }

    private function sanitizeForTease(string $string): string
    {
        $string = trim($string);

        //remove html
        $string = strip_tags($string);

        //replace multiple spaces
        $string = preg_replace("/\s+/", ' ', $string);

        return $string;
    }

    public function replaceFirst(mixed $search, string $replace): static
    {
        if ((string)$search === '') {
            return $this;
        }

        $position = strpos($this->string, $search);

        if ($position === false) {
            return $this;
        }

        $resultString = substr_replace($this->string, $replace, $position, strlen($search));

        return new static($resultString);
    }

    public function replaceLast(mixed $search, string $replace): static
    {
        if ((string)$search === '') {
            return $this;
        }

        $position = strrpos($this->string, $search);

        if ($position === false) {
            return $this;
        }

        $resultString = substr_replace($this->string, $replace, $position, strlen($search));

        return new static($resultString);
    }

    /**
     * Prefix a string.
     *
     * @param $string
     *
     * @return \Spatie\String\Str
     */
    public function prefix($string): static
    {
        return new static($string.$this->string);
    }

    /**
     * Suffix a string.
     *
     * @param $string
     *
     * @return \Spatie\String\Str
     */
    public function suffix(mixed $string): static
    {
        return new static($this->string.$string);
    }

    public function concat(mixed $string): static
    {
        return $this->suffix($string);
    }

    /**
     * Get the possessive version of a string.
     *
     * @return \Spatie\String\Str
     */
    public function possessive(): static
    {
        if ($this->string === '') {
            return new static();
        }

        $noApostropheEdgeCases = ['it'];

        if (in_array($this->string, $noApostropheEdgeCases)) {
            return new static($this->string.'s');
        }

        return new static($this->string.'\''.($this->string[strlen($this->string) - 1] !== 's' ? 's' : ''));
    }

    /**
     * Get a segment from a string based on a delimiter.
     * Returns an empty string when the offset doesn't exist.
     * Use a negative index to start counting from the last element.
     *
     * @param string $delimiter
     * @param int    $index
     *
     * @return \Spatie\String\Str
     */
    public function segment(string $delimiter, int $index): static
    {
        $segments = explode($delimiter, $this->string);

        if ($index < 0) {
            $segments = array_reverse($segments);
            $index = abs($index) - 1;
        }

        $segment = isset($segments[$index]) ? $segments[$index] : '';

        return new static($segment);
    }

    public function firstSegment(string $delimiter): static
    {
        return (new static($this->string))->segment($delimiter, 0);
    }

    public function lastSegment(string $delimiter): static
    {
        return (new static($this->string))->segment($delimiter, -1);
    }

    /**
     * Pop (remove) the last segment of a string based on a delimiter.
     *
     * @param string $delimiter
     *
     * @return \Spatie\String\Str
     */
    public function pop(string $delimiter): static
    {
        return (new static($this->string))->replaceLast($delimiter.$this->lastSegment($delimiter), '');
    }

    public function trim(string $characterMask = " \t\n\r\0\x0B"): static
    {
        return new static(trim($this->string, $characterMask));
    }

    public function contains(array | string $needle, bool $caseSensitive = false, bool $absolute = false): bool
    {
        return $this->find($needle, $caseSensitive, $absolute);
    }

    /**
     * Unknown methods calls will be handled by various integrations.
     *
     * @param $method
     * @param $args
     *
     * @return mixed|\Spatie\String\Str
     *@throws UnknownFunction
     *
     */
    public function __call($method, $args)
    {
        $underscore = new Underscore();

        if ($underscore->isSupportedMethod($method)) {
            return $underscore->call($this, $method, $args);
        }

        throw new UnknownFunction(sprintf('String function %s does not exist', $method));
    }

    public function offsetExists($offset)
    {
        return strlen($this->string) >= ($offset + 1);
    }

    public function offsetGet($offset)
    {
        $character = $this->string[$offset] ?? '';

        return new static($character);
    }

    public function offsetSet($offset, $value)
    {
        $this->string[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        throw new UnsetOffset();
    }
}
