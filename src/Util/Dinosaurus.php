<?php


namespace App\Util;


use Doctrine\ORM\Mapping as ORM;

class Dinosaurus
{

    /**
     * @ORM\Column(type="integer")
     */private $length = 0;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $genus;
    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isCarnivor;


    public function __construct(string $genus = 'unknown', bool $isCarnivor = false)
    {
        $this->genus = $genus;
        $this->isCarnivor = $isCarnivor;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setLength(int $len)
    {
        $this->length = $len;
    }

    public function getSpecification()
    {
        return sprintf('The %s %scarnivourous dino is %d meter long',
            $this->genus,
            $this->isCarnivor ? '' : 'non-',
            $this->length);
    }


}