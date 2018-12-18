<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {
            $book = new Product();
            $book->setName($this->faker->sentence());
            $book->setPrice($this->faker->numberBetween(5, 60));
            $book->setDescription($this->faker->paragraph());

            $book->setCategory($this->getReference(CategoryFixture::BOOKS_CATEGORY_REFERENCE));
            $manager->persist($book);
        }
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            CategoryFixture::class,
        ];
    }
}
