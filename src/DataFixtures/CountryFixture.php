<?php

namespace App\DataFixtures;

use App\Entity\Country;
use Doctrine\Common\Persistence\ObjectManager;

class CountryFixture extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $country = new Country();
            $country->setName($this->faker->country);
            $manager->persist($country);
        }
        $manager->flush();
    }
}
