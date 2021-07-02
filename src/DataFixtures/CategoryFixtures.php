<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    const CATEGORIES = ["html", "PHP", "React", "Redux", "Symfony"];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $value) {
            $category = new Category();
            $category->setName($value);

            $this->addReference("category_$key", $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
