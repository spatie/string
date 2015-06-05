<?php

namespace Spatie\String;

class String
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
     * @return String
     */
    public function between($start, $end)
    {
        if ($start == '' && $end == '')
        {
            return $this;
        }

        if ($start != '' && strpos($this->string, $start) === false)
        {
            return new String();
        }

        if ($end != '' && strpos($this->string, $end) === false)
        {
            return new String();
        }

        if ($start == '')
        {
            return new String(substr($this->string, 0, strpos($this->string, $end)));
        }

        if ($end == '')
        {
            return new String(substr($this->string, strpos($this->string, $start) + strlen($start)));
        }

        $stringWithoutStart = explode($start, $this->string)[1];

        $middle = explode($end, $stringWithoutStart)[0];

        return new String($middle);
    }

    /**
     * Convert the string to uppercase.
     *
     * @return String
     */
    public function toUpper()
    {
        return new String(strtoupper($this->string));
    }

    /**
     * Convert the string to lowercase.
     *
     * @return String
     */
    public function toLower()
    {
        return new String(strtolower($this->string));
    }

    /**
     * Shortens a string in a pretty way. It will clean it by trimming
     * it, remove all double spaces and html. If the string is then still
     * longer than the specified $length it will be shortened. The end
     * of the string is always a full word concatinated with the
     * specified moreTextIndicator.
     *
     * @param int $length
     * @param string $moreTextIndicator
     * @return String
     */
    public function tease($length = 200, $moreTextIndicator = '...')
    {
        $sanitizedString = $this->sanitizeForTeaste($this->string);

        if (strlen($sanitizedString) == 0)
        {
            return new String();
        }

        if (strlen($sanitizedString) <= $length) {
            return new String($sanitizedString);
        }

        $ww = wordwrap($sanitizedString, $length, "\n");
        $shortenedString = substr($ww, 0, strpos($ww, "\n")).$moreTextIndicator;

        return new String($shortenedString);
    }

    /**
     * Sanitize the string for teasing.
     *
     * @param $string
     * @return string
     */
    private function sanitizeForTeaste($string)
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
     * @return String
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

        return new String($resultString);
    }

}

