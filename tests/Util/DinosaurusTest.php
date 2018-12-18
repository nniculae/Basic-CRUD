<?php
/**
 * Created by PhpStorm.
 * User: nicu
 * Date: 18-12-2018
 * Time: 9:17
 */

namespace App\Tests\Util;

use App\Util\Dinosaurus;
use PHPUnit\Framework\TestCase;

class DinosaurusTest extends TestCase
{
    public function testSettingLength()
    {

        $dinosaurus = new Dinosaurus();
        $this->assertSame(0, $dinosaurus->getLength());

        $dinosaurus->setLength(9);
        $this->assertSame(9, $dinosaurus->getLength());

    }

    public function testDinosaurusNotShrunk()
    {
        $dino = new Dinosaurus();
        $dino->setLength(15);

        $this->assertGreaterThan(12, $dino->getLength(),
            "Ai intrat la apa?");

    }

    public function testReturnFullSpecificationDinasaurus()
    {
        $dino = new Dinosaurus();

        $this->assertSame("The unknown non-carnivourous dino is 0 meter long", $dino->getSpecification());
    }

    public function testReturnsFullSpecificationsForTyro()
    {
        $dino = new Dinosaurus('Tyro', true);
        $dino->setLength(12);

        $this->assertSame('The Tyro carnivourous dino is 12 meter long', $dino->getSpecification());
    }

}