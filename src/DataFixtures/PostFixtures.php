<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PostFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $post = new Post();
            $post
                ->setTitle("Post $i")
                ->setContent("Content blabla")
                ->setImage("https://via.placeholder.com/300");

            $category = $this->getReference("category_" . rand(0, 4));
            $post->addCategory($category);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
