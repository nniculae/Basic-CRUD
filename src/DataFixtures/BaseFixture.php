<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

abstract class BaseFixture extends Fixture
{

    abstract protected function loadData(ObjectManager $manager);

    /** @var ObjectManager */
    protected $manager;
    /** @var Generator */
    protected $faker;


    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        $this->loadData($manager);
    }
}
