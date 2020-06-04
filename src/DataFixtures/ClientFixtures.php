<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends BaseFixture
{
    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(20, 'clients', function() {
            $client = new Client();
            $client->setNom($this->faker->lastName);
            $client->setPrenom($this->faker->firstName);
            $client->setAdresse($this->faker->address);
            $client->setVille($this->faker->city);
            $client->setCodePostale($this->faker->postcode);
            $client->setTelephone($this->faker->phoneNumber);
            $client->setMail($this->faker->email);
            return $client;
        });
        $manager->flush();
    }
}
