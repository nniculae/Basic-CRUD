<?php


namespace App\Tests\Service;


use App\Service\DinosaurLengthDeterminator;
use App\Util\Dinosaur;
use PHPUnit\Framework\TestCase;

class DinosaurLengthDeterminatorTest extends TestCase
{
    /**

     * @dataProvider getSpecificationTests
     */
    public function testItReturnsCorrectLengthRange($spec, $minExpectedSize, $maxExpectedSize)
    {
        $determinator = new DinosaurLengthDeterminator();
        $actualSize = $determinator->getLengthFromSpecification($spec);
        $this->assertGreaterThanOrEqual($minExpectedSize, $actualSize);
        $this->assertLessThanOrEqual($maxExpectedSize, $actualSize);

    }

    public function getSpecificationTests()
    {
        // specification, min length, max length
        yield    ['large carnivorous dinosaur', Dinosaur::LARGE, Dinosaur::HUGE - 1];
        yield  ['give me all the cookies!!!', 0, Dinosaur::LARGE - 1];
        yield  ['large herbivore', Dinosaur::LARGE, Dinosaur::HUGE - 1];

        yield ['huge dinosaur', Dinosaur::HUGE, 100];
        yield ['huge dino', Dinosaur::HUGE, 100];
        yield ['huge', Dinosaur::HUGE, 100];
        yield ['OMG', Dinosaur::HUGE, 100];

    }

}