<?php


namespace App\Util;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dinosaurs")
 * Class Dinosaur
 * @package App\Util
 */
class Dinosaur
{
    const LARGE = 10;
    const HUGE = 30;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dinosaur", inversedBy="dinosaurs")
     * @var
     */
    private $enclosure;
    /**
     * @ORM\Column(type="integer")
     */
    private $length = 0;
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

    public function getGenus()
    {
        return $this->genus;
    }

    public function isCarnivorous()
    {
        return $this->isCarnivor;
    }


}