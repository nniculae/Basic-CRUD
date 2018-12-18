<?php


namespace App\Util;


class Dinosaurus
{

    private $length = 0;
    /**
     * Dinosaurus constructor.
     */
    public function __construct()
    {
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength(int $len)
    {
        $this->length = $len;
    }
}