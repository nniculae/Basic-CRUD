<?php


namespace App\Tests\Service;


use App\Entity\Enclosure;
use App\Factory\DinosaurFactory;
use App\Service\EnclosureBuilderService;
use App\Util\Dinosaur;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class EnclosureBuilderServiceTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $em->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(Enclosure::class));

        $dinoFactory = $this->createMock(DinosaurFactory::class);

        $dinoFactory->expects(
            $this->exactly(2))
            ->method('growFromSpecification')
            ->willReturn(new Dinosaur())
            ->with($this->isType('string'));
        $builder = new EnclosureBuilderService($em, $dinoFactory);
        $enclosure = $builder->buildEnclosure(1, 2);
        $this->assertCount(1, $enclosure->getSecurities());
        $this->assertCount(2, $enclosure->getDinosaurs());

    }


}