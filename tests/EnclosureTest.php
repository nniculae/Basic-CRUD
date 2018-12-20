<?php


namespace App\Tests;

use App\Entity\Enclosure;
use App\Exceptions\DinosaursAreRunningRampantException;
use App\Exceptions\NotABuffetException;
use App\Util\Dinosaur;
use PHPUnit\Framework\TestCase;

class EnclosureTest extends TestCase
{
    public function testItHasNoDinosaursByDefault()
    {
        $enclosure = new Enclosure();
        $this->assertEmpty($enclosure->getDinosaurs());
    }

    public function testItAddsDinosaurs()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2, $enclosure->getDinosaurs());

    }

    public function testItDoesNotAllowCarnivorousDinosaursToMixWithHerbivores()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur());

        $this->expectException(NotABuffetException::class);
        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));

    }

    /**
     * @expectedException App\Exceptions\NotABuffetException
     * @throws NotABuffetException
     * @throws DinosaursAreRunningRampantException
     */
    public function testItDoesNotAllowNonCarnivorousDinosaursToCarnivorousEnclosure()
    {
        $enclosure = new Enclosure(true);
        $enclosure->addDinosaur(new Dinosaur('Velociraptor', true));
        $enclosure->addDinosaur(new Dinosaur());
    }

    public function testItDoesNotAllowToAddDinosaursToUnsecureEnclosures()
    {
        $enclosure = new Enclosure();
        $this->expectException(DinosaursAreRunningRampantException::class);
        $this->expectExceptionMessage('Are you mad?');

        $enclosure->addDinosaur(new Dinosaur());

    }


}
