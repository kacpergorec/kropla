<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use App\Factory\PageFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Admin user
        $admin = UserFactory::createOne([
            'firstName' => 'Kacper',
            'lastName' => 'Górec',
            'password' => '123',
            'email' => 'kacpergorec@gmail.com',
            'roles' => ['ROLE_ADMIN']
        ]);
//
//        $user = UserFactory::createOne([
//            'firstName' => 'Christopher',
//            'lastName' => 'Nolan',
//            'password' => '$2y$13$wKsbs97oe.oNgIzTrNI.LOcAdqZjSloyQwgAHqGWLetWIUVduHwAa',
//            'email' => 'nolan@ception.com',
//            'roles' => ['ROLE_ADMIN']
//        ]);
//
//        $users = [$admin,$user];
//
//
//        $categories = CategoryFactory::createMany(3);
//
//        PageFactory::createMany(20, static function () use ($users, $categories) {
//            return [
//                'category' => $categories[array_rand($categories)],
//                'author' => $users[array_rand($users)],
//            ];
//        });
//
//        $manager->flush();

    }
}
