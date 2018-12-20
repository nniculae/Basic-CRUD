<?php
/**
 * Created by PhpStorm.
 * User: nicu
 * Date: 18-12-2018
 * Time: 12:53
 */

namespace App\Tests\Factory;

use App\Factory\DinosaurFactory;
use App\Service\DinosaurLengthDeterminator;
use App\Util\Dinosaur;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{
    /** @var DinosaurFactory */
    private $factory;

    /** @var \PHPUnit_Framework_MockObject_MockObject */
    private $lengthDeterminator;

    public function setUp()
    {

        $this->lengthDeterminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($this->lengthDeterminator);
    }

    public function testItGrowsALargeVelociraptor()
    {
        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }

    public function testItGrowsAVelociraptor()
    {
        $dinosaur = $this->factory->growVelociraptor(5);
        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());
    }

    public function testItGrowsATriceraptors()
    {
        $this->markTestIncomplete('Waiting for confirmation from GenLab');
    }

    public function testItGrowsABabyVelociraptor()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to watch the baby!');
        }

        $dinosaur = $this->factory->growVelociraptor(1);

        $this->assertSame(1, $dinosaur->getLength());
    }

    /**
     * @dataProvider getSpecificationTests
     */
    public function testItGrowsADinosaurFromSpecification(string $spec, bool $expectedIsCarnivorous)
    {

        $this->lengthDeterminator->expects($this->once())
            ->method('getLengthFromSpecification')
            ->with($spec)
            ->willReturn(20);
        $dinosaur = $this->factory->growFromSpecification($spec);

        $this->assertSame($expectedIsCarnivorous, $dinosaur->isCarnivorous(), 'Diets do not match');
        $this->assertSame(20, $dinosaur->getLength());

    }

    public function getSpecificationTests()
    {
        // specification, is carnivorous
        yield    ['large carnivorous dinosaur', true];
        yield  ['give me all the cookies!!!', false];
        yield  ['large herbivore', false];

    }


}
