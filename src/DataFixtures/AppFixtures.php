<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\PageFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $categories = CategoryFactory::createMany(3);

        PageFactory::createMany(20, static function () use ($categories) {
            return [
                'category' => $categories[array_rand($categories)],
            ];
        });

        $manager->flush();
    }
}
