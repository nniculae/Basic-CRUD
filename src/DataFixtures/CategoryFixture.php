<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixture extends BaseFixture
{
    public const BOOKS_CATEGORY_REFERENCE = 'category-books';

    public function loadData(ObjectManager $manager)
    {

        $books = new Category();
        $books->setName('Books');
        $this->addReference(self::BOOKS_CATEGORY_REFERENCE, $books);
        $manager->persist($books);


        $manager->flush();
    }
}
