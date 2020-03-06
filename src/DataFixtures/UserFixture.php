<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_users', function() {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setPrenom($this->faker->firstName);
            $user->setNom($this->faker->lastName);
            $user->setLogin($this->faker->userName);
            return $user;
        });
        $manager->flush();
    }
}
