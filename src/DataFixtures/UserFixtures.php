<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class UserFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        //Admin user
        $user = UserFactory::createOne([
            'firstName' => 'Kacper',
            'lastName' => 'Górec',
            'password' => '$2y$13$wKsbs97oe.oNgIzTrNI.LOcAdqZjSloyQwgAHqGWLetWIUVduHwAa',
            'email' => 'kacpergorec@gmail.com',
            'roles' => ['ROLE_ADMIN']
        ]);

        $manager->flush();
    }
}
