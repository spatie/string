<?php

namespace Spatie\String;

class String
{
    protected $string;

    public function __construct($string)
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
            return new String('');
        }

        if ($end != '' && strpos($this->string, $end) === false)
        {
            return new String('');
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




}

