<?php

namespace Spatie\String;

use ArrayAccess;
use Spatie\String\Exceptions\UnknownFunctionException;
use Spatie\String\Exceptions\UnsetOffsetException;
use Spatie\String\Integrations\Underscore;

/**
 * Magic methods provided by underscore are documented here.
 * 
 * @see \Underscore\Methods\StringsMethods
 * 
 * @method \Spatie\String\String accord($count, $many, $one, $zero = null)
 * @method \Spatie\String\String random($length = 16)
 * @method \Spatie\String\String quickRandom($length = 16)
 * @method randomStrings($words, $length = 10)
 * @method bool endsWith($needles)
 * @method bool isIp()
 * @method bool isEmail()
 * @method bool isUrl()
 * @method bool startsWith()
 * @method bool find($needle, $caseSensitive = false, $absolute = false)
 * @method array slice($slice)
 * @method \Spatie\String\String sliceFrom($slice)
 * @method \Spatie\String\String sliceTo($slice)
 * @method \Spatie\String\String baseClass()
 * @method \Spatie\String\String prepend($with)
 * @method \Spatie\String\String append($with)
 * @method \Spatie\String\String limit($limit = 100, $end = '...')
 * @method \Spatie\String\String remove($remove)
 * @method \Spatie\String\String replace($replace, $with)
 * @method \Spatie\String\String toggle($first, $second, $loose = false)
 * @method \Spatie\String\String slugify($separator = '-')
 * @method array explode($with, $limit = null)
 * @method \Spatie\String\String lower()
 * @method \Spatie\String\String plural()
 * @method \Spatie\String\String singular()
 * @method \Spatie\String\String upper()
 * @method \Spatie\String\String title()
 * @method \Spatie\String\String words($words = 100, $end = '...')
 * @method \Spatie\String\String toPascalCase()
 * @method \Spatie\String\String toSnakeCase()
 * @method \Spatie\String\String toCamelCase()
 */
class String implements ArrayAccess
{
    protected $string;

    public function __construct($string = '')
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->string;
    }

    /**
     * Get the string between the given start and end.
     *
     * @param $start
     * @param $end
     *
     * @return \Spatie\String\String
     */
    public function between($start, $end)
    {
        if ($start == '' && $end == '') {
            return $this;
        }

        if ($start != '' && strpos($this->string, $start) === false) {
            return new self();
        }

        if ($end != '' && strpos($this->string, $end) === false) {
            return new self();
        }

        if ($start == '') {
            return new self(substr($this->string, 0, strpos($this->string, $end)));
        }

        if ($end == '') {
            return new self(substr($this->string, strpos($this->string, $start) + strlen($start)));
        }

        $stringWithoutStart = explode($start, $this->string)[1];

        $middle = explode($end, $stringWithoutStart)[0];

        return new self($middle);
    }

    /**
     * Convert the string to uppercase.
     *
     * @return \Spatie\String\String
     */
    public function toUpper()
    {
        return new self(strtoupper($this->string));
    }

    /**
     * Convert the string to lowercase.
     *
     * @return \Spatie\String\String
     */
    public function toLower()
    {
        return new self(strtolower($this->string));
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
     * @return \Spatie\String\String
     */
    public function tease($length = 200, $moreTextIndicator = '...')
    {
        $sanitizedString = $this->sanitizeForTease($this->string);

        if (strlen($sanitizedString) == 0) {
            return new self();
        }

        if (strlen($sanitizedString) <= $length) {
            return new self($sanitizedString);
        }

        $ww = wordwrap($sanitizedString, $length, "\n");
        $shortenedString = substr($ww, 0, strpos($ww, "\n")).$moreTextIndicator;

        return new self($shortenedString);
    }

    /**
     * Sanitize the string for teasing.
     *
     * @param $string
     *
     * @return string
     */
    private function sanitizeForTease($string)
    {
        $string = trim($string);

        //remove html
        $string = strip_tags($string);

        //replace multiple spaces
        $string = preg_replace("/\s+/", ' ', $string);

        return $string;
    }

    /**
     * Replace the last occurrence of a string.
     *
     * @param $search
     * @param $replace
     *
     * @return \Spatie\String\String
     */
    public function replaceLast($search, $replace)
    {
        if ($search == '') {
            return $this;
        }

        $position = strrpos($this->string, $search);

        if ($position === false) {
            return $this;
        }

        $resultString = substr_replace($this->string, $replace, $position, strlen($search));

        return new self($resultString);
    }

    /**
     * Prefix a string.
     *
     * @param $string
     *
     * @return \Spatie\String\String
     */
    public function prefix($string)
    {
        return new self($string.$this->string);
    }

    /**
     * Suffix a string.
     *
     * @param $string
     *
     * @return \Spatie\String\String
     */
    public function suffix($string)
    {
        return new self($this->string.$string);
    }

    /**
     * Concatenate a string.
     *
     * @param $string
     *
     * @return \Spatie\String\String
     */
    public function concat($string)
    {
        return $this->suffix($string);
    }

    /**
     * Get the possessive version of a string.
     *
     * @return \Spatie\String\String
     */
    public function possessive()
    {
        return new self($this->string.'\''.($this->string[strlen($this->string) - 1] != 's' ? 's' : ''));
    }

    /**
     * Get a segment from a string based on a delimiter.
     * Returns an empty string when the offset doesn't exist.
     * Use a negative index to start counting from the last element.
     * 
     * @param string $delimiter
     * @param int $index
     * 
     * @return \Spatie\String\String
     */
    public function segment($delimiter, $index)
    {
        $segments = explode($delimiter, $this->string);

        if ($index < 0) {
            $segments = array_reverse($segments);
            $index    = abs($index) - 1;
        }

        $segment = isset($segments[$index]) ? $segments[$index] : '';

        return new static($segment);
    }

    /**
     * Get the first segment from a string based on a delimiter.
     * 
     * @param string $delimiter
     * 
     * @return \Spatie\String\String
     */
    public function firstSegment($delimiter)
    {
        return (new static($this->string))->segment($delimiter, 0);
    }

    /**
     * Get the last segment from a string based on a delimiter.
     * 
     * @param string $delimiter
     * 
     * @return \Spatie\String\String
     */
    public function lastSegment($delimiter)
    {
        return (new static($this->string))->segment($delimiter, -1);
    }

    /**
     * Pop (remove) the last segment on a string based on a delimiter
     * 
     * @param string $delimiter
     * 
     * @return \Spatie\String\String
     */
    public function pop($delimiter)
    {
        return (new static($this->string))->replaceLast($delimiter.$this->lastSegment($delimiter), '');
    }

    /**
     * Strip whitespace (or other characters) from the beginning and end of a string
     * 
     * @param string $characterMask
     * 
     * @return \Spatie\String\String
     */
    public function trim($characterMask = " \t\n\r\0\x0B")
    {
        return new static(trim($this->string, $characterMask));
    }

    /**
     * Unknown methods calls will be handled by various integrations.
     *
     * @param $method
     * @param $args
     *
     * @return mixed|\Spatie\String\String
     *
     * @throws UnknownFunctionException
     */
    public function __call($method, $args)
    {
        $underscore = new Underscore();

        if ($underscore->isSupportedMethod($method)) {
            return $underscore->call($this, $method, $args);
        }

        throw new UnknownFunctionException(sprintf('String function %s does not exist', $method));
    }

    /**
     * Whether a offset exists.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset An offset to check for.
     *
     * @return bool true on success or false on failure.
     *              The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return !is_null($this->offsetGet($offset));
    }

    /**
     * Offset to retrieve.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset The offset to retrieve.
     *
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        $character = substr($this->string, $offset, 1);

        return new self($character ?: '');
    }

    /**
     * Offset to set.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset The offset to assign the value to.
     * @param mixed $value  The value to set.
     */
    public function offsetSet($offset, $value)
    {
        $this->string[$offset] = $value;
    }

    /**
     * Offset to unset.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset The offset to unset.
     *
     * @throws UnsetOffsetException
     */
    public function offsetUnset($offset)
    {
        throw new UnsetOffsetException();
    }
}
